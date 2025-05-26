<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class ChamadosModel extends Model
{
    public function insert(array $data)
    {
        return DB::table('sgo_chamado')->insert($data);
    }


    public function  getChamadosByClinete($clientes)
    {
        //@Deprecated 09/04
        // return DB::table('chamados')
        //     ->join('localidades', 'chamados.localidade', '=', 'localidades.localidade')
        //     ->join('clientes', 'clientes.idCLiente', '=', 'localidades.idCliente')
        //     ->where('clientes.id', '=', $clientes)->orderBy('numero_chamado','desc')
        //     ->paginate(config('pagination.CHAMADOS'));

        return DB::table('sgo_chamado')
                 ->selectRaw('sgo_chamado.*')
                ->join('sgo_localidade','sgo_chamado.id_localidade','=','sgo_localidade.id_localidade')
                ->where('sgo_localidade.id_cliente','=',$clientes)
                ->orderBy('sgo_chamado.numero_chamado','DESC')
                ->paginate(config('pagination.CHAMADOS'));
    } 


    public function getChamadosFechados($id_cliente)
    {
        return DB::table('sgo_chamado')->selectRaw('COUNT(sgo_chamado.data_fechamento) as fechados')
        ->join('sgo_localidade','sgo_chamado.id_localidade','=','sgo_localidade.id_localidade')
        ->where('sgo_localidade.id_cliente','=',$id_cliente)
        ->whereNotNull('sgo_chamado.data_fechamento')
        ->get();
    }


    public function getChamadosCancelados($id_cliente)
    {
        return DB::table('sgo_chamado')->selectRaw('COUNT(sgo_chamado.data_fechamento) as fechados')
        ->join('sgo_localidade','sgo_chamado.id_localidade','=','sgo_localidade.id_localidade')
        ->where('sgo_localidade.id_cliente','=',$id_cliente)
        ->whereNotNull('sgo_chamado.status')
        ->get();
    }

    public function getDetalhesChamado($numero_chamado_interno, $serial)
    {
        //@Deprecated 09/04
        // return DB::table('chamados')->where('numero_chamado_interno', '=', $numero_chamado_interno)
        //     ->where('numero_serial', '=', $serial)->orderBy('data_fechamento', 'desc')
        //     ->limit('1')
        //     ->get();

        return DB::table('sgo_chamado')
                 ->selectRaw('sgo_chamado.*')
                 ->where('sgo_chamado.numero_chamado_interno','=', $numero_chamado_interno)
                 ->orderBy('sgo_chamado.data_fechamento','desc')
                 ->limit('1')
                 ->get();
    }

    
    public function getRating($numero_chamado)
    {
        //@Deprecated 09/04
        // return DB::table('chamados')->where('numero_chamado_interno', '=', $numero_chamado_interno)
        //     ->where('numero_serial', '=', $serial)->orderBy('data_fechamento', 'desc')
        //     ->limit('1')
        //     ->get();

        return DB::table('sgo_chamado')
                 ->selectRaw('sgo_chamado.avaliacao, sgo_chamado.uid')
                 ->where('sgo_chamado.numero_chamado','=', $numero_chamado)
                 ->get();
    }


    public function updateRating($uid, $rating)
    {
        return DB::table('sgo_chamado')->where('uid','=',$uid)->update(['avaliacao'=>$rating]);
    }


    public function getTotalAbertos($id_cliente)
    {
        $SQL =" SELECT COUNT(a.status) as abertos FROM sgo_chamado as a
                JOIN sgo_cliente as c ON a.cliente LIKE c.nome_cliente
                WHERE c.id_cliente=".$id_cliente." AND a.status='ABERTO' AND a.data_criacao between (CURDATE() - INTERVAL 1 MONTH) and CURDATE() ";
        return DB::select($SQL);
    }


    public function getTotalFechados($id_cliente)
    {
        $SQL =" SELECT COUNT(a.status) as fechados FROM sgo_chamado as a
        JOIN sgo_cliente as c ON a.cliente LIKE c.nome_cliente
        WHERE c.id_cliente=".$id_cliente." AND a.status='FECHADO' AND a.data_criacao between (CURDATE() - INTERVAL 1 MONTH) and CURDATE() ";
        return DB::select($SQL);
    }



}
