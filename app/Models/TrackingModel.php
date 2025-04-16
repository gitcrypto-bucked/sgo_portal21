<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class TrackingModel extends Model
{
    #status_descricao atualizacao dos correios /transpordora
    # 0 andamento,  1 entregue , 2 cancalado

    #tracking code null-> postado
    #tracking code null  & status ==2> postado   dot cancalado
    #tracking code !null & status !=1 -> transporte
    #tracking code !null & status ==2 -> transporte dot cancelado
    #status = 1  -> entregue

    public function  getTracking($clienteID)
     {
            //@deprecated altered 08/4
            //    return DB::select("SELECT
            //                     sgo_rastreamento.numero_pedido, sgo_rastreamento.nfe, sgo_rastreamento.data_faturamento, sgo_rastreamento.tracking_code, max(sgo_rastreamento.data_ocorrencia) as data, sgo_rastreamento.previsaoEntrega,
            //                     (SELECT status FROM rastreamento r2 WHERE r2.numero_pedido = sgo_rastreamento.numero_pedido ORDER BY data_ocorrencia DESC LIMIT 1) as st,
            //                     (SELECT id FROM rastreamento r2 WHERE r2.numero_pedido = sgo_rastreamento.numero_pedido ORDER BY data_ocorrencia DESC LIMIT 1) as id
            //                 FROM
            //                   rastreamento as r
            //                 GROUP BY numero_pedido, tracking_code, nfe, data_faturamento , previsaoEntrega");

            //@deprecated altered 11/4
            // return DB::select("SELECT sgo_rastreamento.pedido_rastreamento, sgo_rastreamento.nfe_rastreamento, sgo_rastreamento.data_entrega_rastreamento, sgo_rastreamento.codigo_produto_rastreamento, max(sgo_rastreamento.data_faturamento_rastreamento) as data_faturamento_rastreamento, sgo_rastreamento.previsao_entrega_rastreamento,
            //                  (SELECT descricao_status_rastreamento FROM sgo_rastreamento r2 WHERE r2.pedido_rastreamento=sgo_rastreamento.pedido_rastreamento ORDER BY data_faturamento_rastreamento DESC LIMIT 1 ) as st,
            //                  (SELECT id_rastreamento FROM sgo_rastreamento r2 WHERE r2.pedido_rastreamento = sgo_rastreamento.pedido_rastreamento ORDER BY data_faturamento_rastreamento DESC LIMIT 1) as id
            //                  FROM sgo_rastreamento as r
            //                  GROUP BY data_entrega_rastreamento, pedido_rastreamento , codigo_rastreamento , nfe_rastreamento, data_faturamento_rastreamento, previsao_entrega_rastreamento, codigo_produto_rastreamento
            //                     ");

            //@Deprected alterado 11/04
        //    return  DB::table('sgo_rastreamento as r')
        //              ->selectRaw('sgo_rastreamento.pedido_rastreamento, sgo_rastreamento.nfe_rastreamento, sgo_rastreamento.data_entrega_rastreamento, sgo_rastreamento.codigo_produto_rastreamento, max(sgo_rastreamento.data_faturamento_rastreamento) as data_faturamento_rastreamento, sgo_rastreamento.previsao_entrega_rastreamento')
        //              ->addSelect(DB::raw('(SELECT descricao_status_rastreamento FROM sgo_rastreamento r2 WHERE r2.pedido_rastreamento=sgo_rastreamento.pedido_rastreamento ORDER BY data_faturamento_rastreamento DESC LIMIT 1 ) as descricao_status_rastreamento'))
        //              ->addSelect(DB::raw('(SELECT id_rastreamento FROM sgo_rastreamento r2 WHERE r2.pedido_rastreamento = sgo_rastreamento.pedido_rastreamento ORDER BY data_faturamento_rastreamento DESC LIMIT 1) as id'))
        //              ->groupByRaw('data_entrega_rastreamento, pedido_rastreamento , codigo_rastreamento , nfe_rastreamento, data_faturamento_rastreamento, previsao_entrega_rastreamento, codigo_produto_rastreamento')
        //              ->paginate(15);

        return DB::table('sgo_rastreamento')
                    ->selectRaw('	sgo_rastreamento.nfe_rastreamento,
                                    sgo_rastreamento.descricao_status_rastreamento,
                                    sgo_rastreamento.data_entrega_rastreamento,
                                    sgo_rastreamento.previsao_entrega_rastreamento,
                                    sgo_rastreamento.data_faturamento_rastreamento'
                                )
                    ->join('sgo_equipamento','sgo_rastreamento.id_equipamento','=','sgo_equipamento.id_equipamento')
                    ->join('sgo_localidade','sgo_localidade.id_localidade','=','sgo_rastreamento.id_localidade')
                    ->join('sgo_cliente','sgo_cliente.id_cliente','=','sgo_localidade.id_cliente')
                    ->where('sgo_cliente.id_cliente','=',$clienteID)
                    ->groupByRaw('sgo_rastreamento.nfe_rastreamento, sgo_rastreamento.descricao_status_rastreamento, 
                                  sgo_rastreamento.data_entrega_rastreamento, sgo_rastreamento.data_faturamento_rastreamento, 
                                  sgo_rastreamento.previsao_entrega_rastreamento')
                    ->paginate(config('pagination.TRACKING'));

        

     }

    public function getTrackingEquipamento($id_equipamento)
    {   
        $SQL="SELECT            sgo_rastreamento.nfe_rastreamento, 
        sgo_rastreamento.data_faturamento_rastreamento,
        sgo_rastreamento.data_entrega_rastreamento,
        sgo_rastreamento.descricao_status_rastreamento,
        sgo_rastreamento.descricao_produto_rastreamento,
        sgo_rastreamento.codigo_produto_rastreamento,
        sgo_rastreamento.codigo_rastreamento,
        sgo_rastreamento.responsavel_rastreamento,
        sgo_rastreamento.endereco_entrega_rastreamento,
        sgo_rastreamento.numero_entrega_rastreamento,
        sgo_rastreamento.bairro_entrega_rastreamento,
        sgo_rastreamento.cep_entrega_rastreamento,
        sgo_rastreamento.cidade_entrega_rastreamento,
        sgo_rastreamento.estado_entrega_rastreamento,
        sgo_localidade.nome_localidade,
        sgo_rastreamento.id_equipamento,
        sgo_rastreamento.previsao_entrega_rastreamento,
                SUM(sgo_rastreamento.quantidade_rastreamento) AS quantidade_rastreamento
                FROM
                sgo_rastreamento 
                INNER JOIN sgo_localidade   ON sgo_localidade.id_localidade = sgo_rastreamento.id_localidade
                WHERE sgo_rastreamento.id_equipamento = ".$id_equipamento."
                GROUP BY sgo_rastreamento.nfe_rastreamento, 
                sgo_rastreamento.data_faturamento_rastreamento,
                sgo_rastreamento.data_entrega_rastreamento,
        sgo_rastreamento.descricao_status_rastreamento,
        sgo_rastreamento.descricao_produto_rastreamento,
        sgo_rastreamento.codigo_produto_rastreamento,
        sgo_rastreamento.codigo_rastreamento,
        sgo_rastreamento.responsavel_rastreamento,
        sgo_rastreamento.endereco_entrega_rastreamento,
        sgo_rastreamento.numero_entrega_rastreamento,
        sgo_rastreamento.bairro_entrega_rastreamento,
        sgo_rastreamento.cep_entrega_rastreamento,
        sgo_rastreamento.cidade_entrega_rastreamento,
        sgo_rastreamento.estado_entrega_rastreamento,
        sgo_localidade.nome_localidade,
        sgo_rastreamento.id_equipamento,
        sgo_rastreamento.previsao_entrega_rastreamento";
      
        return DB::select(
                $SQL
        );
    }


    public function getTrackingDetails($nfe_rastreamento)
    {
       //@deprecated altered 08/4
       # return DB::table("rastreamento")->where("numero_pedido",$num_pedido)->orderBy('data_ocorrencia','DESC')->get();
        $SQL="SELECT            sgo_rastreamento.nfe_rastreamento, 
                                sgo_rastreamento.data_faturamento_rastreamento,
                                sgo_rastreamento.data_entrega_rastreamento,
                                sgo_rastreamento.descricao_status_rastreamento,
                                sgo_rastreamento.descricao_produto_rastreamento,
                                sgo_rastreamento.codigo_produto_rastreamento,
                                sgo_rastreamento.codigo_rastreamento,
                                sgo_rastreamento.responsavel_rastreamento,
                                sgo_rastreamento.endereco_entrega_rastreamento,
                                sgo_rastreamento.numero_entrega_rastreamento,
                                sgo_rastreamento.bairro_entrega_rastreamento,
                                sgo_rastreamento.cep_entrega_rastreamento,
                                sgo_rastreamento.cidade_entrega_rastreamento,
                                sgo_rastreamento.estado_entrega_rastreamento,
                                sgo_localidade.nome_localidade,
                                SUM(sgo_rastreamento.quantidade_rastreamento) AS quantidade_rastreamento
                                FROM
                                sgo_rastreamento 
                                INNER JOIN sgo_localidade   ON sgo_localidade.id_localidade = sgo_rastreamento.id_localidade
                                WHERE sgo_rastreamento.nfe_rastreamento = ".$nfe_rastreamento."
                                GROUP BY sgo_rastreamento.nfe_rastreamento, 
                                sgo_rastreamento.data_faturamento_rastreamento,
                                sgo_rastreamento.data_entrega_rastreamento,
                        sgo_rastreamento.descricao_status_rastreamento,
                        sgo_rastreamento.descricao_produto_rastreamento,
                        sgo_rastreamento.codigo_produto_rastreamento,
                        sgo_rastreamento.codigo_rastreamento,
                        sgo_rastreamento.responsavel_rastreamento,
                        sgo_rastreamento.endereco_entrega_rastreamento,
                        sgo_rastreamento.numero_entrega_rastreamento,
                        sgo_rastreamento.bairro_entrega_rastreamento,
                        sgo_rastreamento.cep_entrega_rastreamento,
                        sgo_rastreamento.cidade_entrega_rastreamento,
                        sgo_rastreamento.estado_entrega_rastreamento,
                        sgo_localidade.nome_localidade";
        return DB::select(
                $SQL
        );
    }
}
