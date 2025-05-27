<?php


namespace App\graph;
use Illuminate\Support\Facades\DB;


class GraphChamados
{
    public function getGraph($id_cliente, $periodo_inicio ,$periodo_fim )
    {
        // $SQL = " SELECT a.data_criacao, a.data_fechamento,
        //         (SELECT count(b.status) FROM sgo_chamado as b WHERE b.status LIKE 'ABERTO' ) as 'ABERTO',
        //         (SELECT count(c.status) FROM sgo_chamado as c WHERE c.status LIKE 'FECHADO' AND c.data_fechamento!='') AS 'FECHADO'
        //         FROM sgo_chamado as a 
        //         JOIN sgo_cliente as s ON a.cliente LIKE s.nome_cliente
        //         WHERE s.id_cliente=".$id_cliente." AND 
        //         (a.data_criacao BETWEEN '".$periodo_inicio."' AND '".$periodo_fim."' )
        //         GROUP BY a.data_criacao, a.data_fechamento ";

        $SQL = "select a.*, cast(a.data_criacao as date), DATE_FORMAT(a.data_criacao, '%Y-%m-%d')as data_criacao 
                FROM sgo_chamado as a
                JOIN sgo_cliente as s ON a.cliente = s.nome_cliente 
                WHERE s.id_cliente=".$id_cliente." AND (a.data_criacao BETWEEN '".$periodo_inicio."' AND '".$periodo_fim."') 
                GROUP BY a.uid ";
        return DB::select($SQL);
    }


    public function getTotalChamados($id_cliente,$periodo_inicio ,$periodo_fim )
    {
        $SQL =  "
                    SELECT c.uid,
                           (SELECT count(c2.status) FROM sgo_chamado c2 WHERE  c2.status LIKE 'ABERTO' ) as  ABERTO,
                           (SELECT count(c3.status) FROM sgo_chamado c3 WHERE  c3.status LIKE 'FECHADO' ) as  FECHADO
                    FROM sgo_chamado as c
                    JOIN sgo_cliente as s ON c.cliente = s.nome_cliente 
                    WHERE s.id_cliente=".$id_cliente." AND (c.data_criacao BETWEEN '".$periodo_inicio."' AND '".$periodo_fim."') 
                    GROUP BY c.uid

                ";
                  return DB::select($SQL);
    }


    public function getEquipamentosRecorrentes($id_cliente, $periodo_inicio, $periodo_fim)
    {
            $SQL = "SELECT  
            e.modelo_equipamento  ,        
            e.serial_equipamento,
            l.nome_localidade,
            c.data_criacao,
            COUNT(c.id_equipamento) as RECORENCIAS
            FROM
            sgo_chamado as c
            JOIN sgo_equipamento e ON c.id_equipamento = e.id_equipamento
            JOIN sgo_localidade l ON l.id_localidade = e.id_localidade
            WHERE
            l.id_cliente = ".$id_cliente."
            AND (
                c.data_criacao BETWEEN '".$periodo_inicio."'  AND '".$periodo_fim."'
            )
            GROUP BY
            c.uid";
            return DB::select($SQL);
    }


    public function getChamadosPorMes($id_cliente)
    {
        $SQL = "select a.* , MONTHNAME(a.data_criacao) as mes ,YEAR(a.data_criacao) as ano
                FROM sgo_chamado as a
                JOIN sgo_cliente as s ON a.cliente = s.nome_cliente 
                WHERE s.id_cliente=".$id_cliente." AND a.status='ABERTO'
                GROUP BY a.uid ,  MONTHNAME(a.data_criacao) + '.' + YEAR(a.data_criacao)";
        return DB::select($SQL);
    }

}