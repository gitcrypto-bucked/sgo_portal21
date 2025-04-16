<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class LoginModel extends Model
{

    public function partnerExists($token)
    {
        //@Deprecated
        // return  DB::table('clientes')->select(DB::raw(' users.*'))
        // ->join('users', 'users.cliente', '=', 'clientes.id')
        // ->where('clientes.token','=',$token)->where('clientes.active','=','1')
        // ->groupByRaw('clientes.id, users.id')
        // ->exists();


        //new database

        return DB::table('sgo_cliente')
                ->select(DB::raw(' users.*'))
                ->join('users','users.id_cliente','=','sgo_cliente.id_cliente')
                ->where('sgo_cliente.token_cliente','=',$token)
                ->where('sgo_cliente.active','=', '1')
                ->groupByRaw('sgo_cliente.id_cliente, users.id_cliente')
                ->exists();
    }
}
