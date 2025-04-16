<?php

namespace App\Http\Controllers;

use App\Models\ClientesModel;
use App\Models\User;
use Helpers\Helpers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\UserModel;
use Illuminate\Support\Facades\Http;


class UserController extends Controller
{

    
    public function newUser(Request $request)
    {
        $cliente = base64_decode($request->cliente);
        return view('add_user')->with('cliente',$cliente);
    }

    //salva dados de cadastro de usuario, envia e-mail para o mesmo cadastrar a senha
    public function createNewUser(Request $request)
   {
           $request->validate([
               'name' => 'required',
               'email' => 'required|email|unique:users',
               'confirm_email'=> 'required|same:email',
               'empresa'=>'required',
               'centrocusto'=>'',
          ]);

        #dd($request->all()); exit;

        $empresa = $request->empresa;
        $model = new ClientesModel();

        $client= $model->getClient($request->empresa)   ; 
        $user_token = $client[0]->token_cliente;
        $clientID =$client[0]->id_cliente;
        unset($model);

       if($request->email!=$request->confirm_email)
       {
           return redirect('/new_user',['cliente'=> base64_encode($empresa)])->with('error', 'O email não coincide com o de confirmação.');
       }

       /**** GLPI ********/

       $app_token = config('glpi.token') ;
       //realiza o login do usuario no glpi -> retorna o token de sessao
       #$login_return = $glpi->intiSession(config('glpi.login'), config('glpi.password'));
       $result =event(new \App\Events\GLPILogin(config('glpi.login'), config('glpi.password')));

       $session_token = $result[0]['session_token'];
 
       $glpi_password = Helpers::generateStrongPassword();
       $glpi_username =  Helpers::buildUsernameGLPI($request->name); 


       //-----create new user
       $data = [
           'input' => [
               "name"=> $glpi_username,
               "firstname"=>  Helpers::getUsernameSurname($request->name)['firstName'],
               "surname"=> Helpers::getUsernameSurname($request->name)['lastName'],
               "email"=> $request->email,
               "entities_id" =>'0',
               "authtype"=> '1',
               "is_active"=> '1',
               "password" => addslashes(password_hash($glpi_password,PASSWORD_DEFAULT)),
           ],
       ];

       $curl = curl_init();

       curl_setopt_array($curl, array(
         CURLOPT_URL => static::$baseURL.'User/',
         CURLOPT_RETURNTRANSFER => true,
         CURLOPT_ENCODING => '',
         CURLOPT_MAXREDIRS => 10,
         CURLOPT_TIMEOUT => 0,
         CURLOPT_FOLLOWLOCATION => true,
         CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
         CURLOPT_CUSTOMREQUEST => 'POST',
         CURLOPT_POSTFIELDS =>json_encode($data),

         CURLOPT_HTTPHEADER => array(
           'app-token: '.$app_token,
           'session-token:'.$session_token,
           'Content-Type: application/json'
         ),
       ));
       curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);

       $response = curl_exec($curl);
       if (curl_errno($curl)) 
       {
            #event(new \App\Events\GlPIerror(['error'=>'Glpi apirest timeout','glpi_username'=>$glpi_username, 'email'=>$request->email ]));
            return \Redirect::route('new_user',['cliente'=> base64_encode($empresa)])->with('error', 'Houve um erro ao cadastrar o usuario! ');
       }
       curl_close($curl);
       if(strpos($response,'["ERROR_GLPI_ADD"'))
       {
            return \Redirect::route('new_user',['cliente'=> base64_encode($empresa)])->with('error', 'Houve um erro ao cadastrar o usuario ja existe! ');
       }
       $glpi_id = json_decode($response,true); 
       
       //--------update user email
       if(!isset($glpi_id['id']))
       {
            #event(new \App\Events\GlPIerror(['error'=>$glpi_id,'glpi_username'=>$glpi_username, 'email'=>$request->email ]));
            return \Redirect::route('new_user',['cliente'=> base64_encode($empresa)])->with('error', 'Houve um erro ao cadastrar o usuario! ');
       }

       $data = [
            'input' => [
                "users_id"=>addslashes($glpi_id['id']),
                "email"=> $request->email,
                "is_default"=> 1
            ],
        ];

       $curl = curl_init();

       curl_setopt_array($curl, array(
         CURLOPT_URL => static::$baseURL.'UserEmail/',
         CURLOPT_RETURNTRANSFER => true,
         CURLOPT_ENCODING => '',
         CURLOPT_MAXREDIRS => 10,
         CURLOPT_TIMEOUT => 0,
         CURLOPT_FOLLOWLOCATION => true,
         CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
         CURLOPT_CUSTOMREQUEST => 'POST',
         CURLOPT_POSTFIELDS =>json_encode($data),
         CURLOPT_HTTPHEADER => array(
           'app-token: '.$app_token,
           'session-token:'.$session_token,
           'Content-Type: application/json'
         ),
       ));
       curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);

       $response = curl_exec($curl);
       if (curl_errno($curl)) 
       {
            #event(new \App\Events\GlPIerror(['error'=>'Glpi apirest timeout','glpi_username'=>$glpi_username, 'email'=>$request->email ]));
            return \Redirect::route('new_user',['cliente'=> base64_encode($empresa)])->with('error', 'Houve um erro ao cadastrar o usuario! ');
       }
       curl_close($curl);


       $data = [
            'input' => [
                "users_id"=>addslashes($glpi_id['id']),
                "profiles_id" =>'13',
                "is_recursive"=>1,
                "entities_id" =>'0'
            ],
        ];


        $curl = curl_init();

        curl_setopt_array($curl, array(
        #CURLOPT_URL => $glpi_url.'Profile_User',
        CURLOPT_URL => static::$baseURL.'Profile_User',

        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'POST',
        CURLOPT_POSTFIELDS =>json_encode($data),


        CURLOPT_HTTPHEADER => array(
            'app-token: '.$app_token,
            'session-token:'.$session_token,
            'Content-Type: application/json'
        ),
        ));
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);

        $response = curl_exec($curl);

        curl_close($curl);
     
       /**** GLPI END********/

       /*** controle de permissoes ****/
       $dash_faturamento=  str_contains(@$request->dash_faturamento,'on')? '1': '0';
       $dash_chamados=  str_contains(@$request->dash_chamados,'on')? '1': '0';
       $dash_inventario= str_contains(@$request->dash_inventario,'on')? '1': '0';
       $faturamento = str_contains(@$request->faturamento ,'on')? '1': '0';
       $faturamento_details= str_contains(@$request->faturamento_details,'on')? '1': '0';
       $inventario = str_contains(@$request->inventario,'on')? '1': '0';
       $inventario_details= str_contains(@$request->inventario_details,'on')? '1': '0';
       $chamados=  str_contains(@$request->chamados,'on')? '1': '0';
       $chamados_details=  str_contains(@$request->chamados_details,'on')? '1': '0';
       $tracking= str_contains(@$request->tracking,'on')? '1': '0';
       $tracking_details= str_contains(@$request->tracking_details,'on')? '1': '0';
       $abrir_chamado= str_contains(@$request->abrir_chamado,'on')? '1': '0';

       /*** controle de permissoes ****/

       $created_at= date('Y-m-d H:i:s', time());

       $ok= $model = new UserModel();
       $model->addUser(
           $request->name,
           $request->email,
           $request->level,
           $created_at,
           $clientID,
           $request->centrocusto,
           $dash_faturamento,
           $dash_chamados,
           $dash_inventario,
           $faturamento,
           $faturamento_details,
           $inventario,
           $inventario_details,
           $chamados,
           $chamados_details,
           $tracking,
           $tracking_details,
           $abrir_chamado,
           $glpi_id['id'],
           $glpi_username,
           $glpi_password
       );

       $token = md5(bin2hex(random_bytes(32))); // token de acesso para usuario cadastrar

       $model->createPasswordReset($request->email, $token, $created_at);

       $createUserPassWordURL =route("user-token",$token);

       event(new \App\Events\RegistredUser(['name'=>$request->name, 'email'=>$request->email, 'user_token'=> $user_token, 'url'=>$createUserPassWordURL]));


       if($ok!=false)
       {
            return \Redirect::route('new_user',['cliente'=> base64_encode($empresa)])->with('success', 'Cadastro Realizado com Sucesso! ');
       }
       else
       {
            return \Redirect::route('new_user',['cliente'=> base64_encode($empresa)])->with('error', 'Houve um erro ao cadastrar o usuario! ');
       }
    }



    //usuario cadastrado, valida se o token de acesso é valido e envia para pagina de alterar senha
    public function checkUserToken(Request $request)
    {
        $token = $request->token;
        $model = new UserModel();
        $user =$model->getUserAndTokenValid($token);

        if(isset($user[0]) && !empty($user[0]))
        {
            return view("password-update",['user' =>  $user, 'token'=>$request->token]); //envia para view o usuario alterar a senha
        }
        if(!isset($user[0]) && empty($user[0]))
        {
            return redirect('/expired_link');  // o usuario ja alterou a senha ou token expirou
        }
    }

    //usuario cadastrado, permite cadastrar senha de acesso via link
    //funciona no fluxo de recuperar senha
    public function registerUserPassword(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'email',
            'company'=>'required',
            'password' => 'required|min:8',
            'passwordConfirmation' => 'min:8',
        ]);

        if(strtolower($request->password )!= strtolower($request->passwordConfirmation))
        {
            return view("password-update")->with('error', 'A senha e confirmação de senha não coincidem!');
        }
        DB::table('users')->where('email', $request->email)->update(['empresa'=>$request->empresa, 'password'=> Hash::make($request->senha),]);
        DB::table('password_reset_tokens')->where('token','=',$request->token)->delete();

        return redirect('/login')->with('success', 'Senha Cadastrada com Sucesso!');
    }


    // Usuario cadastrado e logado Permite alterar sua senha
    public function updateUser(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'email|unique:users',
            'senha' => 'required|min:8',
            'confsenha' => 'min:8',
        ]);

        User::updated([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->senha),
        ]);
        return redirect('/user-profile')->with('success', 'Dados atualizados com sucesso.');

    }

    /**fluxo para recuperação de senha, */
    /**verifica se usuario está cadastrado e ativo*/

    public function recoverPassword(Request $request)
    {
        $request->validate([
            'typeEmailX' => 'required|email'
        ]);
        $email = $request->typeEmailX;
        $model = new UserModel();
        $user = $model->getUserByEmail($email)[0];
        if($user->partner!='1')
        {
            return redirect('/forgot-password')->with('error', 'Usuario invalido!'); //parceiro desabilitado
        }
        $token = md5(bin2hex(random_bytes(32))); // token de acesso para usuario cadastrar

        $model->createPasswordReset($user->email, $token, date('Y-m-d H:i:s'));

        $createUserPassWordURL =route("user-token",$token);

        event(new \App\Events\UserRecovered(['name'=>$user->name, 'email'=>$user->email, 'user_token'=>$user->user_token, 'url'=>$createUserPassWordURL]));

        return redirect('/forgot-password')->with('success', 'Você receberá em instantes, um link no seu email cadastrado!');

    }

    public function forgotPassword():string
    {
        return view('password-recover');
    }


    public function filterUsers(Request $request)
    {
        $model = new UserModel();

        $cliente = $request->cliente;
        $filter = strtolower($request->input('filter'));
        if($filter =='')
        {
            $users = $model->getClientUsers($filter,$cliente);
            return view('cliente_users')->with('users', $users)->with('cliente', $cliente)->with('error', "Não foi possivel concuir a pesquisa");
        }
        if($request->flexCheckDefault=='1')
        {
            $users = $model->getFilterClienteUser($filter,$cliente,true);
        }
        else
        {
            $users = $model->getFilterClienteUser($filter,$cliente,false);

        }
        if(sizeof($users) >= 0)
        {
            return view('cliente_users')->with('users', $users)->with('cliente', $cliente);
        }
        $users = $model->getClientUsers($cliente);
        return view('cliente_users')->with('users', $users)->with('cliente', $cliente);
    }


    public function redirectView($clients, $error =null)
    {
        if($error != null)
        {
            return view('usuarios_clientes')->with('error', $error)->with('clients', $clients);
        }
        return view('usuarios_clientes')->with('clients', $clients);
    }

    public  function trocarTela(Request $request)
    {
        $cliente = base64_decode($request->cliente);
        $idCliente = base64_decode($request->idCliente);
        $admin = Auth::user(); // Usuário administrador logado
        $user = DB::table('users')->where('cliente', '=', $idCliente)->first();
        session(['original_user' => $admin]); // Guarda o ID do admin
        if(is_null($user))
        {
            return redirect('/cliente_manager')->with('error',"Não é possivel acessar este cliente!");
        }
        if(Auth::loginUsingId($user->id))
        {
            return  redirect('/faturamento'); // Redireciona para a página desejada
        }
        return  redirect('/faturamento'); // Redireciona para a página desejada
    }

    public function switchBack(Request $request)
    {
        $originalUser = session('original_user');
        if ($originalUser)
        {
            Auth::loginUsingId($originalUser->id);
            session()->forget('original_user');
        }
        return redirect('/cliente_manager');
    }



    function deactiveUser(Request $request)
    {
        $id = base64_decode($request->id);
        $cliente = ($request->cliente);
        $model = new UserModel();
        if($model->deactive($id))
        {
            return \Redirect::route('usuarios_clientes',['cliente'=>$cliente]);
        }
    }


    function deleteUser(Request $request)
    {
        $id = base64_decode($request->id);
        $cliente = ($request->cliente);
        $model = new UserModel();
        if($model->remove($id))
        {
            return \Redirect::route('usuarios_clientes',['cliente'=>$cliente]);
        }
    }


    function activeUser(Request $request)
    {
        $id = base64_decode($request->id);
        $cliente = ($request->cliente);
        $model = new UserModel();
        if($model->active($id))
        {
            return \Redirect::route('usuarios_clientes',['cliente'=>$cliente]);
        }
    }

    private static $baseURL = "https://lcdesk.lowcost.com.br/apirest.php/";

}
