<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;


class SearchModel extends Model
{

    public function searchInventario($cliente,$localidade)
    {

        return DB::table('clientes')
            ->selectRaw('localidades.localidade ,COUNT(equipamentos.id) AS quantidade, clientes.cliente')->distinct('equipamentos.idserial')
            ->leftJoin('localidades','localidades.idCliente', '=', 'clientes.idCliente')
            ->leftJoin('equipamentos', 'equipamentos.idLocalidade','=','localidades.idLocalidade')
            ->where('localidades.localidade', '=', $localidade)
            ->groupByRaw('localidades.localidade, clientes.cliente')
            ->paginate(config('pagination.INVENTORIES'));
    }


    public function searchInventarioDetalheWithModelo($localidade,$model)
    {
        // return DB::table('equipamentos')
        // ->join('localidades','localidades.idLocalidade','=','equipamentos.idLocalidade')
        // ->where('localidades.localidade','=','GERDAU ACOMINAS MINA MIGUEL BURNIER')
        // ->where('equipamentos.modelo','like','%'.$model.'%')
        // ->paginate(config('pagination.INVENTORIES'));

        return DB::select("SELECT e.*, l.localidade, s.* FROM equipamentos as  e
            JOIN localidades as l ON l.idLocalidade = e.idLocalidade
            LEFT JOIN suprimentos s ON s.numero_serie_impressora=e.serial
             WHERE l.localidade='".$localidade."' AND  e.modelo LIKE '".$model."' ORDER BY COALESCE(e.imagem,'') DESC ");
    }
}
