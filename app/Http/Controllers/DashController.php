<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\graphController;
use Illuminate\Http\Request;
use App\graph\GraphFaturamento;
use App\graph\GraphChamados;

use \Helpers\Helpers;
date_default_timezone_set("America/Sao_Paulo");
class DashController extends Controller
{
    //
    public function postLogin(Request $request)
    {
        $paginate = Config::get('pagination.NEWS');
        
        $model = new \App\Models\NewsModel();
        $news =  $model->getAllNews(intval($paginate));
        unset($model);

        $model = new \App\Models\ChamadosModel();
        $abertos = $model-> getTotalAbertos(Auth::user()->id_cliente)[0]->abertos;
        $fechados = $model->getTotalFechados(Auth::user()->id_cliente)[0]->fechados;

        return view('dash')->with('news',$news)->with('abertos', $abertos)->with('fechados',$fechados);
    }


    public function getDashboardChamados(Request $request)
    {
        $dataInicio = null;
        $dataFim = null;

        $aberto = [];
        $fechado = [];
        $recorrencias = [];

        $modelos = [];
        $serial = [];
        $localidade = [];

        if(empty($request->all()))
        {
             $dataInicio = Date('Y').'-'.Date('m').'-01';

            $date = new \DateTime('now');
            $date->modify('last day of this month');
            $dataFim =  $date->format('Y-m-d');
        }
        else
        {
            $dataInicio = date('Y-m-d',strtotime($request->dataInicio));
            $dataFim = date('Y-m-d',strtotime($request->dataFim));
        }

        $datelist = Helpers::getDatesFromRange($dataInicio, $dataFim,'d-M-y');

        $gra = new GraphChamados();

        $graph = $gra->getGraph(Auth::user()->id_cliente, $dataInicio, $dataFim);

        $totals = $gra->getTotalChamados(Auth::user()->id_cliente, $dataInicio, $dataFim)[0];

        $recorrente =  $gra->getEquipamentosRecorrentes(Auth::user()->id_cliente, $dataInicio, $dataFim);

        $chamaosMes  = $gra->getChamadosPorMes(Auth::user()->id_cliente);

        $mesesAno = Helpers::getMounths();
        
        
        unset($gra);


        for($i=0; $i < sizeof($datelist); $i++)
        {
            array_push($aberto, ['date'=>$datelist[$i],'close'=>0]);
            array_push($fechado,['date'=>$datelist[$i],'close'=>0]);
            array_push($recorrencias, ['date'=>$datelist[$i], 'modelo'=>0, 'serial'=>0, 'localidade'=>'', 'recorrencia'=>0 ]);
            #array_push($tikets, ['Time'=> $datelist[$i], 'TICKETS_CREATED'=>0 , 'TICKETS_RESOLVED'=>0]);
        }

        for($i=0; $i<sizeof($graph); $i++)
        {
            if($graph[$i]->status=='ABERTO' &&  array_search( addslashes(date("d-M-y", strtotime($graph[$i]->data_criacao))) , array_column($aberto, 'date'))!=false )
            {
                $key =    array_search( addslashes(date("d-M-y", strtotime($graph[$i]->data_criacao))) , array_column($aberto, 'date'));
                $aberto[$key]['close'] = 1;
            }
            if($graph[$i]->status=='FECHADO' &&  array_search( addslashes(date("d-M-y", strtotime($graph[$i]->data_fechamento))) , array_column($fechado, 'date'))!=false )
            {
                $key =    array_search( addslashes(date("d-M-y", strtotime($graph[$i]->data_fechamento))) , array_column($fechado, 'date'));
                $fechado[$key]['close'] = 1;
            }
        }

        for($i =0; $i<sizeof($aberto); $i++)
        {
            unset($aberto[$i]['date']);
            $aberto[$i] = $aberto[$i]['close'];
        }
        for($i =0; $i<sizeof($fechado); $i++)
        {
            unset($fechado[$i]['date']);
            $fechado[$i] = $fechado[$i]['close'];
        }



        //---------------------------chamados-------------------------------------
        $meses = [];
        
        for($i = 0; $i < sizeof($mesesAno); $i++)
        {
           array_push($meses, ['mes'=> $mesesAno[$i], 'aberto'=>0]);
        }

        for($i= 0; $i< sizeof($chamaosMes); $i++)
        {
             if( array_search( addslashes($chamaosMes[$i]->mes) , array_column($meses, 'mes'))!=false )
             {
                    $key = array_search( addslashes($chamaosMes[$i]->mes) , array_column($meses, 'mes'));
                    $meses[$key]['aberto']+=1;
             }
        }

        $chamadosAbertos = array_column($meses,'aberto');
        $meses = array_column($meses,'mes');

        #dd($chamadosAbertos, $meses);

        //--------------------------------------------------------------------------



        // for($i =0 ; $i < sizeof($recorrente); $i++)
        // {
        //     if( array_search( addslashes(date("d-M-y", strtotime($recorrente[$i]->data_criacao))) , array_column($recorrencias, 'date'))!=false )
        //     {
        //         $key = array_search( addslashes(date("d-M-y", strtotime($recorrente[$i]->data_criacao))) , array_column($recorrencias, 'date'));
        //         #dd($key);
        //         $recorrencias[$key]['modelo'] = $recorrente[$i]->modelo_equipamento;
        //         $recorrencias[$key]['serial'] = $recorrente[$i]->serial_equipamento;
        //         $recorrencias[$key]['localidade'] = $recorrente[$i]->nome_localidade;
        //         $recorrencias[$key]['recorrencia'] = $recorrente[$i]->RECORENCIAS;
        //     }
        // }



        // $aberto = array_values($aberto);
        // $fechado = array_values($fechado);

        // $modelos = array_column($recorrencias, 'modelo');
        // $serial = array_column($recorrencias, 'serial');
        // $localidade = array_values(array_column($recorrencias, 'localidade'));
                //var_export($localidade); exit;


        #dd($recorrencias, sizeof($recorrencias), sizeof($datelist), $modelos, $serial, $localidade);
        return view('dashboard_chamados')
                ->with('dataInicio',$dataInicio)
                ->with('dataFim',$dataFim)
                ->with('abertos',$aberto)
                ->with('fechados',$fechado)
                ->with('datelist',$datelist)
                ->with('totals',$totals)

                ->with('meses',$meses)
                ->with('chamadosAbertos', $chamadosAbertos)
                
                // ->with('modelo',$modelos)
                //  ->with('serial', $serial)
                // ->with('localidade',$localidade)
                // ->with('recorrencias',$recorrencias)
                ;
    }

    public function getDashboardFaturamento(Request $request)
    {
        //
        if(empty($request->all()))
        {
            $dataInicio = Date('Y').'-'.Date('m').'-01';

            $date = new \DateTime('now');
            $date->modify('last day of this month');
            $dateFim =  $date->format('Y-m-d');

            $gra = new GraphFaturamento();
            $graph = $gra->getGraph(Auth::user()->id_cliente, $dataInicio, $dateFim);
            unset($gra);

            return view('dashboard_invoice');
        }
        else
        {

        }
    }
}
