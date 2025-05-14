<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;


class LocalidadeModel extends Model
{


    public function getLocalidadeById($id_localidade)
    {
        return DB::table('sgo_localidade')->where('id_localidade','=',$id_localidade)->get();
    }


    public function getLocalidadeByCliente($id_cliente)
    {
        return DB::table('sgo_localidade')->where('id_cliente','=',$id_cliente)->get(['id_localidade','nome_localidade']);

    }


    public function getLocalidadeByIdEquipamento($id_equipamento)
    {
        return DB::table('sgo_localidade')
                 ->join('sgo_equipamento','sgo_equipamento.id_localidade','=','sgo_localidade.id_localidade')
                 ->where('sgo_equipamento.id_equipamento','=',$id_equipamento)
                 ->get(['sgo_localidade.id_localidade','sgo_localidade.nome_localidade']);
    }
    
}
