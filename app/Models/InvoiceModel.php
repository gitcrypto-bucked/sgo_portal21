<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class InvoiceModel extends Model
{
    public function insert(array $data)
    {
         return DB::table('faturamento')->insert($data);
    }

    public function getPeriodo($ClientID, $periodo_inicio ,$periodo_fim)
    {
        return DB::table('faturamento')
            ->join('localidades', 'faturamento.localidade', '=', 'localidades.localidade')
            ->join('clientes', 'localidades.idCliente', '=', 'clientes.idCliente')
            ->where('clientes.id', '=', $ClientID)->paginate(config('pagination.INVOICES'));
    }

    public function select($ClientID)
    {
        return DB::table('faturamento as f')
            ->selectRaw('sum(f.valor_total) as cobrado,
                                sum(f.rateado) as rateado,
                                SUM(f.total_percent) as total_percent,
                                DATE_FORMAT(f.periodo_inicio, "%d/%m/%Y") as periodo_inicio_,
										  DATE_FORMAT(f.periodo_fim, "%d/%m/%Y")as periodo_fim_,
                                f.status,
                                f.periodo_inicio, f.periodo_fim')
                    ->join('localidades', 'f.localidade', '=', 'localidades.localidade')
                    ->join('clientes', 'localidades.idCliente', '=', 'clientes.idCliente')
                    ->where('clientes.id', '=', $ClientID)
                    ->groupByRaw('f.status , f.periodo_fim, f.periodo_inicio')
                    ->orderByRaw('periodo_inicio DESC')
                    ->paginate(config('pagination.INVOICES'));
   }


    public function getDetalhes($ClientID, $periodo_inicio ,$periodo_fim, $total)
    {
        return DB::table('faturamento')
            ->join('localidades', 'faturamento.localidade', '=', 'localidades.localidade')
            ->join('clientes', 'localidades.idCliente', '=', 'clientes.idCliente')
            ->havingRaw('SUM(faturamento.cobrado) <= '.$total)
            ->GroupByRaw(' faturamento.uid ,faturamento.cod_servico, localidades.id')
            ->where('clientes.id', '=', $ClientID)
            ->where('faturamento.periodo_inicio', '=', $periodo_inicio)
            ->where('faturamento.periodo_fim', '=', $periodo_fim)
            ->paginate(config('pagination.INVOICES'));

//        return   DB::select("
//                            SELECT * FROM faturamento f
//                                JOIN localidades l ON f.localidade = l.localidade
//                                JOIN clientes c ON c.idCliente= l.idCliente
//                                WHERE c.id=".$ClientID."  AND f.periodo_inicio='".$periodo_inicio."'
//                                AND f.periodo_fim='".$periodo_fim."'
//                                GROUP BY f.uid ,f.cod_servico, l.id
//                                having sum(f.cobrado)<=".$total) ;
    }






}
