<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use function Symfony\Component\Translation\t;

class ClientesModel extends Model
{
    public function listarClientes()
    {
        // altered 08/4
        return DB::table('sgo_cliente')->whereRaw("active ='1'")->get();
    }

    public function getAllClientes()
    {
        //@deprecated altered 08/4
        // SELECT c.*, count(u.id) as total from clientes c
        //LEFT JOIN users u ON c.cliente =u.cliente
        //GROUP BY c.id, u.id */
        //  return DB::table('clientes')->select(DB::raw(' clientes.*, count(users.id) as total '))
        //      ->leftJoin('users', 'users.cliente', '=', 'clientes.cliente')
        //      ->groupByRaw('clientes.id, users.id')
        //      ->paginate(22);

        return DB::table('sgo_cliente')->select(DB::raw('sgo_cliente.* , count(users.id) as total '))
               ->leftJoin('users','users.id_cliente','=','sgo_cliente.id_cliente') 
               ->groupByRaw('sgo_cliente.id_cliente, users.id') 
               ->paginate(config("pagination.CLIENTS"));

    }

    public function getFilterCliente($cliente, $onlyActive= false)
    {
        //@deprecated altered 08/4

        if($onlyActive==false)
        {
            #return DB::table('clientes')->where("cliente","=", $cliente)->get();
            // return DB::select('SELECT c.*, count(u.id) as total FROM clientes c
            //                          LEFT JOIN users u ON u.cliente = c.id
            //                          WHERE c.cliente ="'.$cliente.'" OR c.cliente LIKE "'.$cliente.'%"
            //                          GROUP BY c.id, u.id');

            return DB::select('SELECT c.*, count(u.id) as total FROM sgo_cliente c
                              LEFT JOIN users u ON u.id_cliente  = c.id_cliente
                              WHERE c.nome_cliente="'.$cliente.'" OR c.nome_cliente LIKE "'.$cliente.'%"
                                     GROUP BY c.id_cliente, u.id_cliente');
        }
        else
        {
            // return DB::select('SELECT c.*, count(u.id) as total FROM clientes c
            //                          LEFT JOIN users u ON u.cliente = c.id
            //                          WHERE c.cliente ="'.$cliente.'" OR c.cliente LIKE "'.$cliente.'%"
            //                          AND c.active ="1"
            //                          GROUP BY c.id, u.id');

            return DB::select('SELECT c.*, count(u.id) as total FROM sgo_cliente c
                    LEFT JOIN users u ON u.id_cliente  = c.id_cliente
                    WHERE c.nome_cliente="'.$cliente.'" OR c.nome_cliente LIKE "'.$cliente.'%" AND c.active="1"
                    GROUP BY c.id_cliente, u.id_cliente');
        }

    }

    public function  ativarCliente($clienteID,$logo, $path)
    {
        //@deprecated altered 08/4
        //   DB::table('clientes')->where('idCliente', '=', $clienteID)->update(['active'=>1,'logo' => $logo, 'path' => $path]);
        //  return DB::table('localidades')->where('idCliente',$clienteID)->update(['active' => '1']);

        DB::table('sgo_cliente')->where('id_cliente','=',$clienteID)->update(['active'=>'1','logo_cliente'=>$logo, 'path'=>$path]);
        return DB::table('sgo_localidade')->where('id_cliente','=',$clienteID)->update(['active'=>'1']);
    }

    public function  destivarCliente($clienteID)
    {
        //@deprecated altered 08/4
    //    $ok = DB::statement('UPDATE clientes SET active = 0, deactived_at="'.date('Y-m-d H:i:s').'" WHERE idCliente = '.$clienteID);
    //    $ok= DB::table('localidades')->where('idCliente',$clienteID)->update(['active' => '0']);
    //    return $ok;
          
        $ok = DB::table('sgo_cliente')->where('id_cliente','=',$clienteID)->update(['active'=>'0',]);
        $ok = DB::table('sgo_localidade')->where('id_cliente','=',$clienteID)->update(['active'=>'0']);   
        return $ok;
    }

    public function excluirCliente($clienteID)
    {
        return DB::table('sgo_cliente')->where('id_cliente', '=', $clienteID)->delete();
    }

    public function getClient($id_cliente)
    {
        return DB::table('sgo_cliente')->where("id_cliente","=", intval($id_cliente))->get();
    }

    public  function getClientUsers($cliente)
    {
         //@deprecated altered 08/4
        // return DB::table('clientes')->select(DB::raw(' users.*'))
        //     ->join('users', 'users.cliente', '=', 'clientes.id')
        //     ->where('clientes.cliente','=',$cliente)
        //     ->groupByRaw('clientes.id, users.id')
        //     ->paginate(config("pagination.CLIENTS"));

        return DB::table('sgo_cliente')->select(DB::raw(' users.* '))
               ->join('users', 'users.id_cliente','=','sgo_cliente.id_cliente')
               ->where('sgo_cliente.nome_cliente','=',$cliente)
               ->groupByRaw('sgo_cliente.id_cliente, users.id')
               ->paginate(config("pagination.CLIENTS"));
    }

    public function getCLienteNameBiUd($ID)
    {
        // altered 08/4
        return DB::table('sgo_cliente')->where('id_cliente', $ID)->value('nome_cliente');
    }

    public function updateClienteLogo($clienteID, $logo, $path= null)
    {
         // altered 08/4
        return DB::table('sgo_cliente')->where('id_cliente', $clienteID)->update(['logo_cliente' => $logo]);
    }


    public  function  getLogo($id)
    {
        // altered 08/4
        return DB::table('sgo_cliente')->where('id_cliente', $id)->get();
    }

    public function updateColors($id_cliente,$sidebar,$text)
    {
        return DB::table('sgo_cliente')->where('id_cliente','=',$id_cliente)->update(['header'=>$sidebar,'text'=>$text]);
    }



}
