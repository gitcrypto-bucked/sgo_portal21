<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class InvoiceModel extends Model
{
    public function insert(array $data)
    {
         return DB::table('sgo_faturamento')->insert($data);
    }

    public function getPeriodo($ClientID, $periodo_inicio ,$periodo_fim)
    {
        return DB::table('faturamento')
            ->join('localidades', 'faturamento.localidade', '=', 'localidades.localidade')
            ->join('clientes', 'localidades.idCliente', '=', 'clientes.idCliente')
            ->where('clientes.id', '=', $ClientID)->paginate(config('pagination.INVOICES'));
    }

    public function select($id_cliente)
    {
        //@Deprecated 22/05/2025
        // return DB::table('faturamento as f')
        //     ->selectRaw('sum(f.valor_total) as cobrado,
        //                         sum(f.rateado) as rateado,
        //                         SUM(f.total_percent) as total_percent,
        //                         DATE_FORMAT(f.periodo_inicio, "%d/%m/%Y") as periodo_inicio_,
		// 								  DATE_FORMAT(f.periodo_fim, "%d/%m/%Y")as periodo_fim_,
        //                         f.status,
        //                         f.periodo_inicio, f.periodo_fim')
        //             ->join('localidades', 'f.localidade', '=', 'localidades.localidade')
        //             ->join('clientes', 'localidades.idCliente', '=', 'clientes.idCliente')
        //             ->where('clientes.id', '=', $ClientID)
        //             ->groupByRaw('f.status , f.periodo_fim, f.periodo_inicio')
        //             ->orderByRaw('periodo_inicio DESC')
        //             ->paginate(config('pagination.INVOICES'));

        return  DB::table('sgo_faturamento  AS f')
                  ->selectRaw(
                                'sum(f.valor_total_faturamento) AS cobrado,
                                 sum(f.valor_total_porcento_faturamento) AS total_percent,
                                 f.status_faturamento,
                                 DATE_FORMAT(f.periodo_cobranca_inicio, "%d/%m/%Y") as periodo_inicio_ ,
                                 DATE_FORMAT(f.periodo_cobranca_fim, "%d/%m/%Y")as periodo_fim_ ,
                                 f.periodo_cobranca_inicio, 
                                 f.periodo_cobranca_fim,
                                 f.periodo
                                '
                              )
                  ->join('sgo_localidade', 'f.id_localidade', '=', 'sgo_localidade.id_localidade')  
                  ->where('sgo_localidade.id_cliente', '=', $id_cliente)          
                  ->groupByRaw(
                                '
                                    f.status_faturamento , 
                                    f.periodo_cobranca_inicio, 
                                    f.periodo_cobranca_fim,
                                    f.periodo
                                '
                                )
                  ->orderByRaw('periodo_cobranca_inicio DESC')                            
                  ->get();

   }


    public function getDetalhes($id_cliente, $periodo_inicio ,$periodo_fim, $total)
    {
        //@Deprecates 22/05/2025
        // return DB::table('faturamento')
        //     ->join('localidades', 'faturamento.localidade', '=', 'localidades.localidade')
        //     ->join('clientes', 'localidades.idCliente', '=', 'clientes.idCliente')
        //     ->havingRaw('SUM(faturamento.cobrado) <= '.$total)
        //     ->GroupByRaw(' faturamento.uid ,faturamento.cod_servico, localidades.id')
        //     ->where('clientes.id', '=', $ClientID)
        //     ->where('faturamento.periodo_inicio', '=', $periodo_inicio)
        //     ->where('faturamento.periodo_fim', '=', $periodo_fim)
        //     ->paginate(config('pagination.INVOICES'));

        //        return   DB::select("
        //                            SELECT * FROM faturamento f
        //                                JOIN localidades l ON f.localidade = l.localidade
        //                                JOIN clientes c ON c.idCliente= l.idCliente
        //                                WHERE c.id=".$ClientID."  AND f.periodo_inicio='".$periodo_inicio."'
        //                                AND f.periodo_fim='".$periodo_fim."'
        //                                GROUP BY f.uid ,f.cod_servico, l.id
        //                                having sum(f.cobrado)<=".$total) ;

        return DB::table('sgo_faturamento')
                  ->selectRaw('sgo_faturamento.*, sgo_localidade.nome_localidade, sgo_equipamento.serial_equipamento')
                  ->join('sgo_localidade', 'sgo_faturamento.id_localidade', '=', 'sgo_localidade.id_localidade')  
                  ->join('sgo_equipamento','sgo_faturamento.id_equipamento','=','sgo_equipamento.id_equipamento')
                  ->havingRaw('SUM(sgo_faturamento.valor_total_faturamento) <= '.$total)
                  ->groupByRaw('sgo_faturamento.id_faturamento, sgo_faturamento.codigo_servico_faturamento, sgo_localidade.id_localidade')
                  ->where('sgo_localidade.id_cliente', '=', $id_cliente)
                  ->where('sgo_faturamento.periodo_cobranca_inicio', '=', $periodo_inicio)
                  ->where('sgo_faturamento.periodo_cobranca_fim','=',$periodo_fim)
                  ->paginate(config('pagination.INVOICES'));
                  
       
    }


    public function getDetalhesEquipamento($id_equipamento)
    {
          return DB::table('sgo_faturamento')
                  ->selectRaw(' 
                                sgo_faturamento.*,
                                sgo_localidade.nome_localidade, 
                                sgo_equipamento.serial_equipamento,
                                DATE_FORMAT(sgo_faturamento.periodo_cobranca_inicio, "%d/%m/%Y") as periodo_inicio_ ,
                                DATE_FORMAT(sgo_faturamento.periodo_cobranca_fim, "%d/%m/%Y")as periodo_fim_ ,
                                (SELECT max(d2.periodo_cobranca_inicio) FROM sgo_faturamento d2 WHERE d2.id_faturamento=sgo_faturamento.id_faturamento)
                    ')
                  ->join('sgo_localidade', 'sgo_faturamento.id_localidade', '=', 'sgo_localidade.id_localidade')  
                  ->join('sgo_equipamento','sgo_faturamento.id_equipamento','=','sgo_equipamento.id_equipamento')
                  ->groupByRaw('sgo_faturamento.id_faturamento, sgo_faturamento.codigo_servico_faturamento, sgo_localidade.id_localidade')
                  ->where('sgo_equipamento.id_equipamento', '=', $id_equipamento)
                  //->limit(config('pagination.INVOICES'))
                  ->get();
    }


    public function getTotalCobrado($id_equipamento)
    {
        // return  DB::table('sgo_faturamento  AS f')
        //         ->selectRaw(
        //                     'sum(f.valor_total_faturamento) AS cobrado,
        //                         sum(f.valor_total_porcento_faturamento) AS total_percent,
        //                         f.status_faturamento,
        //                         DATE_FORMAT(f.periodo_cobranca_inicio, "%d/%m/%Y") as periodo_inicio_ ,
        //                         DATE_FORMAT(f.periodo_cobranca_fim, "%d/%m/%Y")as periodo_fim_ ,
        //                         f.periodo_cobranca_inicio, 
        //                         f.periodo_cobranca_fim,
        //                         f.periodo
        //                     '
        //                     )
        //         ->join('sgo_equipamento', 'f.id_equipamento', '=', 'sgo_equipamento.id_equipamento')  
        //         ->where('sgo_equipamento.id_equipamento', '=', $id_equipamento)          
        //         ->groupByRaw(
        //                     '
        //                         f.status_faturamento , 
        //                         f.periodo_cobranca_inicio, 
        //                         f.periodo_cobranca_fim,
        //                         f.periodo
        //                     '
        //                     )
        //         ->orderByRaw('periodo_cobranca_inicio DESC')                            
        //         ->get();

        $SQL = 'select sum(f.valor_total_geral_faturamento) AS cobrado,
                sum(f.valor_total_porcento_faturamento) AS total_percent,
                f.status_faturamento,
                DATE_FORMAT(f.periodo_cobranca_inicio, "%d/%m/%Y") as periodo_inicio_ ,
                DATE_FORMAT(f.periodo_cobranca_fim, "%d/%m/%Y")as periodo_fim_ ,
                f.periodo_cobranca_inicio, 
                f.periodo_cobranca_fim,
                f.periodo
                from `sgo_faturamento` as `f` 
                inner join `sgo_equipamento` on `f`.`id_equipamento` = `sgo_equipamento`.`id_equipamento` 
                where `sgo_equipamento`.`id_equipamento` = '.$id_equipamento.'
                group by 
                f.status_faturamento , 
                f.periodo_cobranca_inicio, 
                f.periodo_cobranca_fim,
                f.periodo
                order by periodo_cobranca_inicio DESC';

                return  DB::select($SQL);
    }
//





}
