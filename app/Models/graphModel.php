<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use function Laravel\Prompts\select;

class graphModel extends Model
{
    public function getDataFaturamento($idCliente, $periodo_inicio='2024-09-22', $periodo_fim= '2024-10-23')
    {
        return DB::select("SELECT SUM(f.cobrado) as tot,f.cod_servico ,f.periodo_inicio, f.periodo_fim , f.volume FROM faturamento f
                            JOIN localidades  l
                            ON f.localidade = l.localidade
                            JOIN clientes c ON l.idCliente = c.idCliente
                            WHERE f.periodo_inicio='".$periodo_inicio."' AND f.periodo_fim='".$periodo_fim."'
                            AND  c.id =".$idCliente."
                            group by  f.cod_servico,  f.volume
                           "); // ORDER BY tot ASC

    }

    //return * Contagem de paginas por Mês.
    public  function  getTotalPrint($idCliente, $periodo_fim= '2024-10-22')
    {
        return DB::select("SELECT SUM(f.rateado) as impresso,f.periodo_inicio,f.periodo_fim FROM faturamento f
                    JOIN localidades  l
                    ON f.localidade = l.localidade
                    JOIN clientes c ON l.idCliente = c.idCliente
                    WHERE (f.periodo_fim = '".$periodo_fim."')
                    AND  c.id =".$idCliente."
                    group by  f.periodo_inicio ,f.periodo_fim");
    }

    //retorna * Soma do valor do Faturamento por mês
    public function  getTotalFaturamento($idCliente, $periodo_fim= '2024-10-22')
    {
        $SQL='SELECT SUM(f.total_geral) as tot,f.periodo_inicio , f.periodo_fim  FROM faturamento f
             JOIN localidades  l
             ON f.localidade = l.localidade
             JOIN clientes c ON l.idCliente = c.idCliente
             WHERE  f.periodo_fim="'.$periodo_fim.'"
             AND  c.id ='.$idCliente.'
            group by f.periodo_inicio , f.periodo_fim';


        return DB::select( $SQL);
    }

    public function getDataChamados($id_cliente, $periodo_inicio, $periodo_fim)
    {
        //Deprecated 16/05/2025
        // return DB::select('SELECT a.periodo_fim,
        //                         (SELECT count(b.sla)FROM chamados b  WHERE b.sla="DENTRO" ) as DENTRO ,
        //                         (SELECT count(c.sla)FROM chamados c  WHERE c.sla="FORA" ) as FORA
        //                      FROM chamados a
        //                      JOIN localidades l ON a.localidade = l.localidade
        //                      JOIN clientes e ON l.idCliente=e.idCliente
        //                      WHERE e.id=55
        //                      AND (periodo_fim BETWEEN "'.$periodo_inicio.'" AND "'.$periodo_fim.'")
        //                      GROUP By a.periodo_fim');

        return DB::select(' SELECT a.data_criacao,
                            (SELECT count(b.status) FROM sgo_chamado as b WHERE b.status="ABERTO") as ABERTO,
                            (SELECT count(c.status) FROM sgo_chamado as c WHERE c.status="FECHADO") AS FECHADO
                         FROM sgo_chamado as a 
                         JOIN sgo_clientes as s ON a.cliente LIKE s.nome_cliente
                         WHERE s.id_cliente='.$id_cliente.' AND 
                         (a.data_cricao BETWEEN "'.$periodo_inicio.'" AND "'.$periodo_fim.'" )
                         GROUP BY a.data_cricao');
     }


    public function  getSLADentroPercent($idCliente, $periodo_fim= '10-22-24')
    {
        return DB::select("select c.periodo_fim ,(( (SELECT count(b.sla)FROM chamados b  WHERE b.sla='DENTRO')/ COUNT(c.numero_chamado)  ) * 100) as percent
                                FROM chamados as c
                                JOIN localidades l ON c.localidade = l.localidade
                                JOIN clientes e ON l.idCliente=e.idCliente
                                WHERE e.id=".$idCliente." AND (c.periodo_fim BETWEEN '09-23-24' AND '".$periodo_fim."')
                                GROUP BY c.periodo_fim");
    }

}
