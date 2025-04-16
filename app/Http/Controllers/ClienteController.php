<?php

namespace App\Http\Controllers;

use App\Models\ClientesModel;
use Illuminate\Http\Request;

class ClienteController extends Controller
{


    public function index()
    {
        $model = new ClientesModel();
        $clients = $model->getAllClientes();
        return view('cliente_manager')->with('clients', $clients);
    }


    public function filterClientes(Request $request)
    {
        $model = new ClientesModel();
        $filter = strtolower($request->input('filter'));
        if($filter =='')
        {
            $clients = $model->getAllClientes();
            return  $this->redirectView($clients,   'Não foi possivel realizar a pesquisa!');
        }
        if($request->flexCheckDefault=='1')
        {
            $clients = $model->getFilterCliente($filter,true);
        }
        else
        {
            $clients = $model->getFilterCliente($filter);
        }

        if(sizeof($clients) >= 0)
        {
            return  $this->redirectView($clients);
        }
        $clients = $model->getAllClientes();
        return  $this->redirectView($clients, 'Não foi possivel encontrar este cliente');
    }

    public function redirectView($clients, $error =null)
    {
        if($error != null)
        {
            return view('cliente_manager')->with('error', $error)->with('clients', $clients);
        }
        return view('cliente_manager')->with('clients', $clients);
    }

    public function RemoveClientes(Request $request)
    {
        $clienteID = $request->id; //refers to clientes.idCliente
        $model = new ClientesModel();
        if($model-> excluirCliente($clienteID)!=false)
        {
            return json_encode(['status' => 202]);
        }
        return json_encode(['status' => 302]);
    }

    public function ActiveClientes(Request $request)
    {
        $clienteID = $request->id; //refers to clientes.idCliente


        if ($request->file('logo')->isValid())
        {
            $file = $request->file('logo');
            $path = $request->file('logo')->storeAs('clientes', $file->hashName());
        }

        $model = new ClientesModel();
        if($model-> ativarCliente($clienteID, $file->hashName(), $path)!=false)
        {
           return json_encode(['status' => 202]);
        }
        return json_encode(['status' => 302]);
    }

    public function DeactiveClientes(Request $request)
    {
        $clienteID = $request->id; //refers to clientes.idCliente
        $model = new ClientesModel();
        if($model->destivarCliente($clienteID))
        {
            return json_encode(['status' => 202]);
        }
        return json_encode(['status' => 302]);
    }

    public function getClienteUserList(Request $request)
    {
        $model = new ClientesModel();
    }

    public  function getUsersFromCliente(Request $request)
    {
        $cliente = base64_decode($request->cliente);
        $model = new ClientesModel();
        $users = $model->getClientUsers($cliente);
        return view('cliente_users')->with('users', $users)->with('cliente', $cliente);
    }

    public function UpdateLogoClientes(Request $request)
    {
        $clienteID = $request->idCliente; //refers to clientes.idCliente
        if ($request->file('logo')->isValid())
        {
            $file = $request->file('logo');
            $path = $request->file('logo')->storeAs('clientes', $file->hashName());
        }
        $model = new ClientesModel();
        if($model->updateClienteLogo($clienteID, $file->hashName(), $path)!=false)
        {
            return json_encode(['status' => 202]);
        }
        return json_encode(['status' => 302]);
    }
}
