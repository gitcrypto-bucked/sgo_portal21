<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;


class SearchModel extends Model
{

    public function searchInventario($id_cliente,$id_localidade)
    {

        // @Deprecated at 05/05
        // return DB::table('clientes')
        //     ->selectRaw('localidades.localidade ,COUNT(equipamentos.id) AS quantidade, clientes.cliente')->distinct('equipamentos.idserial')
        //     ->leftJoin('localidades','localidades.idCliente', '=', 'clientes.idCliente')
        //     ->leftJoin('equipamentos', 'equipamentos.idLocalidade','=','localidades.idLocalidade')
        //     ->where('localidades.localidade', '=', $localidade)
        //     ->groupByRaw('localidades.localidade, clientes.cliente')
        //     ->paginate(config('pagination.INVENTORIES'));
        

        return DB::table('sgo_cliente')
                   ->selectRaw('sgo_localidade.nome_localidade, COUNT(sgo_equipamento.id_equipamento) as quantidade , sgo_cliente.nome_cliente, sgo_localidade.id_localidade')                   
                   ->join('sgo_localidade','sgo_localidade.id_cliente','=','sgo_cliente.id_cliente')
                   ->join('sgo_equipamento','sgo_equipamento.id_localidade','=','sgo_localidade.id_localidade')
                   ->where('sgo_localidade.id_localidade','=',$id_localidade)
                   ->groupByRaw('sgo_localidade.nome_localidade, sgo_localidade.id_localidade, sgo_cliente.nome_cliente')
                   ->paginate(config('pagination.INVENTORIES'));;
    }


    public function searchInventarioDetalheWithModelo($modelo, $id_localidade)
    {
        // return DB::table('equipamentos')
        // ->join('localidades','localidades.idLocalidade','=','equipamentos.idLocalidade')
        // ->where('localidades.localidade','=','GERDAU ACOMINAS MINA MIGUEL BURNIER')
        // ->where('equipamentos.modelo','like','%'.$model.'%')
        // ->paginate(config('pagination.INVENTORIES'));

        //@Deprecated 05/50
        // return DB::select("SELECT e.*, l.localidade, s.* FROM equipamentos as  e
        //     JOIN localidades as l ON l.idLocalidade = e.idLocalidade
        //     LEFT JOIN suprimentos s ON s.numero_serie_impressora=e.serial
        //      WHERE l.localidade='".$localidade."' AND  e.modelo LIKE '".$model."' ORDER BY COALESCE(e.imagem,'') DESC ");

        $SQL = 'SELECT e.*, l.nome_localidade, l.id_localidade, s.* FROM sgo_equipamento as e
                           JOIN sgo_localidade as l ON l.id_localidade = e.id_localidade 
                           LEFT JOIN sgo_suprimento as s ON s.id_equipamento = e.id_equipamento
                           WHERE l.id_localidade ='.$id_localidade.' AND e.serial_equipamento LIKE "'.$modelo.'" ORDER BY COALESCE(e.imagem_equipamento,"") DESC';

        return DB::select($SQL);
    }

    public function getIDCliente($cliente)
    {
        return DB::table('sgo_cliente')
               ->where('nome_cliente','LIKE',$cliente)
               ->get('id_cliente');
    }


    public function getIDLocalidade($localidade)
    {
        return DB::table('sgo_localidade')
               ->where('nome_localidade','LIKE', $localidade)
               ->get('id_localidade');
    }
}
