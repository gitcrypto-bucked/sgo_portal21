<?php

namespace App\Http\Controllers;

use App\Models\ChamadosModel;
use App\Models\ClientesModel;
use App\Models\InventarioModel;

use Helpers\Helpers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\graphController;
use App\Http\Controllers\GLPI;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
ini_set( 'post_max_size' , '28M' );
ini_set('upload_max_filesize','20M');
//###GLPI METHODS
header('Content-Type: text/html; charset=utf-8');

class Chamados extends Controller
{
   
    public function index()
    {
        #return view('chamados-upload');
         echo 'disabled'; exit;
    }

    //redireciona para a view
    public function abrirChamados(Request $request)
    {
        $model = new InventarioModel();
        if(isset($request->serial))
        {
            $modelo=  $model->getEquipamento(base64_decode($request->serial));
            return view('abrir_chamado')->with('modelo',$modelo)->with('id_localidade',base64_decode($request->id_localidade));
        }
        else
        {
            $inventario = $model->getEquipamentos(Auth::user()->id_cliente);
            return view('abrir_chamado')->with('inventario',$inventario);
        }
    }

    public function novoChamados(Request $request)
    {
        // array:7 [▼ // app\Http\Controllers\Chamados.php:51
        //     "_token" => "nq0HLjmlsbcrHEOJyQeSnBPmFePBWSNGEOXm3CEk"
        //     "id_ativo_equipamento" => "15224"
        //     "level" => "0"
        //     "id_localidade" => "9913"
        //     "titulo" => "s"
        //     "descricao" => "s"
        //     "submit" => null
        //     ]
        $id_localidade  = $request->id_localidade;
        $localidade = DB::table('sgo_localidade')->where('id_localidade','=',$id_localidade)->get()[0];
        $entidade = $localidade->entidade_localidade;

        $id_ativo_equipamento = $request->id_ativo_equipamento; //campo sgo_database id_equipamento

        $equipamento = DB::table('sgo_equipamento')->where('id_ativo_equipamento','=',$id_ativo_equipamento)->get()[0];
        $id_equipamento = $equipamento->id_equipamento;
        $serial_equipamento = $equipamento->serial_equipamento;
        $item_type = \Helpers\Helpers::getItemType($equipamento->familia_equipamento);
        

        if($request->hasFile('files')==true)
        {
            
            for($i=0; $i<sizeof($request->file('files')); $i++)
            {
                if(intval($request->file('files')[$i]->getSize())>=16384)
                {
                    return redirect('abrir_chamado')->with('error','O arquivo '.$request->file('files')[$i]->getClientOriginalName().' é maior que o permitido');
                    exit;
                }
            }            
        }    

        $result =event(new \App\Events\GLPILogin(Auth::user()->glpi_username, Auth::user()->glpi_password));
        $session_token = $result[0]['session_token'];


        if(empty($session_token))
        {
            event(new \App\Events\GLPIerror(100,  Auth::user()->glpi_username, Auth::user()->glpi_password));

            return redirect('abrir_chamado')->with('error','Houve um erro ao abrir chamado');
        }

        $g = new \App\Actions\ChangeProfileGLPI(); 
        if($g->changeProfile($session_token)['status']!=200)
        {
            //error handling
            event(new \App\Events\GLPIerror(300,  Auth::user()->glpi_username, Auth::user()->glpi_password));
            return redirect('abrir_chamado')->with('error','Houve um erro ao abrir chamado');
        }
        unset($g);

        $priority = $request->level;
        $titulo = $request->titulo;
        $descricao = $request->descricao;

       
        $data = [
            'input' => [
                'name' => $titulo,
                'content' => $descricao,
                'serial'=>addslashes($serial_equipamento),
                'type' => 2, // Incidente, Solicitação
                'urgency' => $priority,
                'requesters.users'=> Auth::user()->glpi_id,
                'users_id_recipient'=>Auth::user()->glpi_id,
                "profiles_id" =>'13',
                "entities_id" => $entidade
            ],
        ];

        $n = new \App\Actions\GLPInovochamado(); 
        $ticketID = $n->abreChamado($session_token, $data);
        unset($n);


        //Ticket User
        $u = new \App\Actions\Ticket_User();
        $ret =  $u->get($ticketID, Auth::user()->glpi_id, $session_token);
        if(!isset($ret['id']))
        {
            //error
        }
        unset($u);

        //ticket item
        $data = 
        [
            'input' => 
            [
                "items_id"=> $id_ativo_equipamento,
                "itemtype"=> addslashes($item_type),
                "tickets_id"=> $ticketID
            ],
        ];

        $g = new \App\Actions\GLPI_addItemTicket();

        $ret = $g->addItems($data, $ticketID, $session_token);
        if(!isset($ret['id']))
        {
            //error
        }
        unset($g);

        if($request->hasFile('files')==true)
        {
            $documentID= [];
            $upload = new  \App\Actions\GLPIUpload();
            for($i=0; $i<sizeof($request->file('files')); $i++)
            {
                $documentID[$i] = $upload->glpiUpload($request->file('files')[$i], $session_token);
                sleep(1);
            }
            unset($upload);

            $l = new \App\Actions\GLPILink();
            $linkID = [];

            for($i =0; $i< sizeof($documentID); $i++)
            {
                $data = [
                    'input' => [
                         'items_id'=> $ticketID,
                         'itemtype'=> "Ticket",
                         'documents_id'=>$documentID[$i]
                    ],
                ];
                $linkID[$i] = $l->documentItem($data, $session_token);
                
                DB::table('sgo_chamado_x_anexos')->insert(
                [
                    'numero_chamado'=> $ticketID,
                    'documentoID' => $documentID[$i],
                    'linkID' => $linkID[$i] ,
                    'created_at' => date('Y-m-d H:i:s') 
                ]);
            }
            unset($l);
        }

        $ok = DB::table('sgo_chamado')->insert(
            [
                'numero_chamado'=> $ticketID,
                'numero_chamado_interno' => $ticketID,
                'numero_serial' => $serial_equipamento,
                'cliente'=>  strtoupper(Helpers::getUserCompanyName(Auth::user()->id_cliente)),
                'id_localidade'=> intval($id_localidade),
                'data_criacao'=> date('Y-m-d H:i:s'),
                'users_id'=>Auth::user()->id,
                'users_name'=>Auth::user()->name,
                'id_equipamento'=>$id_equipamento
            ]);

        if($ok)
        {
            #return redirect('abrir_chamado')->with('success','Chamado aberto com sucesso');
            return Redirect::back()->with(['success' =>'Chamado aberto com sucesso']);
        }
        else
        {
           # return redirect('abrir_chamado')->with('error','Houve um error ao abrir o chamado');
           return Redirect::back()->with(['error' =>'Houve um error ao abrir o chamado']);
        }
    }

    //-----lista chamados

    public function getChamados(Request $request)
    {
        $model = new ChamadosModel();
        $cliente = Auth::user()->id_cliente;

        $fechados = $model->getChamadosFechados(Auth::user()->id_cliente);

        $chamados = $model->getChamadosByClinete(Auth::user()->id_cliente);
        return view('chamados')->with('chamados', $chamados)->with('fechados',$fechados[0]->fechados);
    }

    //----detalhes chamados ------------------------------
    public function getChamadoDetalhe(Request $request)
    {
        $numero_chamado = base64_decode($request->get('numero_chamado'));

        #need to check if chamado is  in database
        if(DB::table('sgo_chamado')->where('numero_chamado','LIKE',"%".$numero_chamado."%")->exists()!=true)
        {
            return Redirect::back()->with(['error' =>'Número chamado não cadastrado']);
        }

        $model = new ChamadosModel();

        $rating =  $model->getRating($numero_chamado)[0];

        unset($model);

        $app_token = strlen(config('glpi.token')) ? config('glpi.token') :  'P5DPl9uKZ3VpzicnEXPDMQA2D1K0zQbOUQxp61xQ';

        $result =event(new \App\Events\GLPILogin(config('glpi.login'), config('glpi.password')));

        $session_token = $result[0]['session_token'];

        //@Updated 09/04
        $ticketLinks = DB::SELECT("SELECT documentoID FROM sgo_chamado_x_anexos WHERE numero_chamado LIKE '%".$numero_chamado."' ORDER BY created_at DESC");

        $followUpFiles = DB::select("SELECT * FROM sgo_chamado_x_followup  WHERE numero_chamado LIKE '%".$numero_chamado."' ORDER BY created_at DESC");

        $g = new \App\Actions\ChangeProfileGLPI(); 
        $g->changeProfile($session_token)['status'];
        unset($g);

        //---------------get ticket and files

        $t = new \App\Actions\GetTicketGlpi();
        $tiket = $t->getTicket($session_token,$numero_chamado);
        unset($t);

        if(!isset($tiket['links']))
        {
            return Redirect::back()->with(['error' =>'Esse chamado não se encontra no LCDesk']);
        }
        
        
        $d = new \App\Actions\GLPIgetdoucment();
        $ticketFiles = [];

        for($i=0; $i< sizeof($ticketLinks); $i++)
        {
            $ticketFiles[$i]= $d->getDocument($session_token, intval($ticketLinks[$i]->documentoID));
        }
        unset($d);
        
        for($i =0; $i< sizeof($tiket['links']); $i++)
        {
            if(stripos($tiket['links'][$i]['href'], 'ITILFollowup') !=false)
            {
                $ITILFollowup = $tiket['links'][$i]['href'];
            }
            if(stripos($tiket['links'][$i]['href'], 'ITILSolution') !=false)
            {
                $ITILSolution = $tiket['links'][$i]['href'];
            }
        }

        //traz os dados do followup e lista de acordo com a data hora

        $f= new \App\Actions\GLPI_ittilfollowup();
        $follow = $f->getITTILFollowUp($session_token, $ITILFollowup);
        unset($f);

        $s = new \App\Actions\GLPI_ittilSolutions();
        $solution = $s->getITTLSolution($session_token, $ITILSolution);
        unset($s);

        // ordena pela data mais atual -> desativado
        // usort($follow, function($a, $b) {
        //     return strtotime($b['date_mod']) - strtotime($a['date_mod']);
        //   });

        // usort($solution, function($a, $b) {
        //     return strtotime($b['date_mod']) - strtotime($a['date_mod']);
        // });

        //traz os anexos do followup
        $followFiles = [];
        $d = new \App\Actions\GLPI_getFollowUP_DocumentItem();
        $u = new \App\Actions\GetITILUsername();
        for($i=0; $i<sizeof($follow); $i++)
        {
            $follow[$i]['user']= $u->getUsername($follow[$i]['users_id'],$session_token); 
            sleep(1);
             
            $followFiles[$i] =   ['id'=>$follow[$i]['id'], 'files' =>  $d->getDocument_Item(trim($follow[$i]['links'][3]['href']), $session_token, Auth::user()->glpi_id)];  
            sleep(1);   
        }
        unset($d);

        $solutuionFiles = [];
      
        if(!empty($solution))
        {
            $e = new \App\Actions\GLPI_getITTLSolution_DocumentItem();
            for($i= 0; $i<sizeof($solution); $i++)
            {
                $solution[$i]['user']= $u->getUsername($solution[$i]['users_id'],$session_token); 
                sleep(1);

                $solutuionFiles[$i] =   ['id'=>$solution[$i]['id'], 'files' =>  $e->getDocument_Item(trim($solution[$i]['links'][2]['href']), $session_token, Auth::user()->glpi_id)];  
                sleep(1);   
            }
            unset($e);
        }
        unset($u);

        return view('chamados_details')->with('details', $tiket)
                                       ->with('media',$ticketFiles)
                                       ->with('follow',$follow)
                                       ->with('solution', $solution)
                                       ->with('FollowFiles' , $followFiles)
                                       ->with('SoluttionFiles',$solutuionFiles)
                                       ->with('rating',$rating);


    }

    //add FollowUP
    public function addFollowUP(Request $request)
    {
        $numero_chamado = $request->numero_chamado;
        $descricao = $request->descricao;

      


        if($request->hasFile('files')==true)
        {
            
            for($i=0; $i<sizeof($request->file('files')); $i++)
            {
                if(intval($request->file('files')[$i]->getSize())>=16384)
                {
                    return Redirect::back()->with('error','O arquivo '.$request->file('files')[$i]->getClientOriginalName().' é maior que o permitido');
                    
                }
            }            
        } 

        $result =event(new \App\Events\GLPILogin(Auth::user()->glpi_username, Auth::user()->glpi_password));
        $session_token = $result[0]['session_token'];

        $g = new \App\Actions\ChangeProfileGLPI(); 
        if($g->changeProfile($session_token)['status']!=200)
        {
            //error handling
            event(new \App\Events\GLPIerror(300, Auth::user()->glpi_username, Auth::user()->glpi_password));
            return Redirect::back()->with(['error' =>'Houve um erro ao cadastrar um followup']);
        }
        unset($g);

        $data = [
            'input'=>[
                "itemtype" => "Ticket",
                "items_id" => intval($numero_chamado),
                "users_id" => Auth::user()->glpi_id,
                "content" => $descricao,
                "is_private" => 0,
                "requesttypes_id"=> 1,
                "sourceitems_id" => 0,
                "sourceof_items_id" => 0
            ]
        ];

        $f = new  \App\Actions\GLPI_addFollowUp();
        $resp = $f->addTicketFollowUp($session_token, $numero_chamado ,$data);
        unset($f);

        
        if(!isset($resp['id']))
        {
            event(new \App\Events\GLPIerror(500, Auth::user()->glpi_username,$numero_chamado));
            return Redirect::back()->with(['error' =>'Houve um erro ao cadastrar um followup']);
        }

        $followupID = strval($resp['id']);


         //Ticket User
        // $u = new \App\GLPI\Ticket_User();
        // $ret =  $u->get($ticketID, Auth::user()->glpi_id, $session_token);

        // if(!isset($ret['id']))
        // {
        //     return Redirect::back()->with(['error' =>'Houve um erro ao cadastrar um followup']);
        // }
        // unset($u);

        $errors = [];
        if($request->hasFile('files')==true)
        {
            $documentID= [];
            $upload = new  \App\Actions\GLPIUpload();
            for($i=0; $i<sizeof($request->file('files')); $i++)
            {
                $documentID[$i] = $upload->glpiUpload($request->file('files')[$i], $session_token);
                sleep(1);
            }
            unset($upload);

            $l = new \App\Actions\GLPI_FollowUPLink();
            $linkID = [];

            for($i =0; $i< sizeof($documentID); $i++)
            {
                $data = [
                    'input' => [
                         'items_id'=> $followupID,
                         'itemtype'=> "Ticket",
                         'documents_id'=>$documentID[$i]
                    ],
                ];
                $linkID[$i] = $l->documentItem($data, $session_token);

                $errors[$i] =  DB::table('sgo_chamado_x_followup')->insert(
                    [
                        'numero_chamado'=> $numero_chamado,
                        'document_item' => $documentID[$i],
                        'numero_followup' =>$followupID,
                        'created_at' => date('Y-m-d H:i:s') 
                    ]);
            }
            unset($l);
        }

        if(Helpers::same($errors))
        {
            return Redirect::back()->with(['success' => 'Followup cadastrado com sucesso']);              
        }
        else
        {
            return Redirect::back()->with(['error' =>'Houve um erro ao cadastrar um followup']);
        }
    }

    public function getDashboardChamados(Request $request)
    {
        
        $dentro=001;
        $fora =00;
        $target =3;
        $percent = 0;
        return view('dashboard_chamados')->with('dentro',$dentro)->with('fora',$fora)->with('target',$target)->with('percent',$percent);
    }

    //rating da chamada
    public function setRating(Request $request)
    {
        $uid = (int) $request->uid;
        $rating = (int) $request->rating;

        $model = new ChamadosModel();
        if($model->updateRating($uid, $rating)!=false)
        {
            return 200;
        }
        else
            return 300;
    }

}
