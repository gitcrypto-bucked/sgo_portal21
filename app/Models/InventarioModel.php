<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class InventarioModel extends Model
{
    public function  getInventory($cliente)
    {
        //@Deprected alterado 08/04
        // return DB::table('clientes')
        //     ->selectRaw('localidades.localidade ,COUNT(equipamentos.id) AS quantidade, clientes.cliente')->distinct('equipamentos.idserial')
        //     ->leftJoin('localidades','localidades.idCliente', '=', 'clientes.idCliente')
        //     ->leftJoin('equipamentos', 'equipamentos.idLocalidade','=','localidades.idLocalidade')
        //     ->where('clientes.id', '=', $cliente)
        //     ->groupByRaw('localidades.localidade, clientes.cliente')
        //     ->paginate(config('pagination.INVENTORIES'));

        //->distinct('sgo_equipamento.serial_equipamento')
        return DB::table('sgo_cliente')
                   ->selectRaw('sgo_localidade.nome_localidade, COUNT(sgo_equipamento.id_equipamento) as quantidade , sgo_cliente.nome_cliente, sgo_localidade.id_localidade')                   
                   ->join('sgo_localidade','sgo_localidade.id_cliente','=','sgo_cliente.id_cliente')
                   ->join('sgo_equipamento','sgo_equipamento.id_localidade','=','sgo_localidade.id_localidade')
                   ->where('sgo_cliente.id_cliente','=', $cliente)
                   ->groupByRaw('sgo_localidade.nome_localidade, sgo_localidade.id_localidade, sgo_cliente.nome_cliente')
                   ->paginate(config('pagination.INVENTORIES'));;

    }

    public function getEquipamentos($cliente)
    {
         //@Deprected alterado 08/04
        #return DB::select('SELECT e.* FROM equipamentos as e JOIN localidades l ON l.idLocalidade = e.idLocalidade JOIN clientes c ON c.idCliente = l.idCliente WHERE c.id='.$cliente);
        return DB::select('SELECT e.* FROM sgo_equipamento as e JOIN sgo_localidade l on l.id_localidade=e.id_localidade 
                            JOIN sgo_cliente c on c.id_cliente = l.id_cliente WHERE c.id_cliente='.$cliente);
    }


    public function getLocalidades($cliente)
    {
        //@Deprected alterado 08/04
        // return DB::select('SELECT DISTINCT c.cliente, l.localidade , count(e.id) as total FROM clientes c
        //         LEFT JOIN localidades l ON l.idCliente = c.idCliente
        //         LEFT JOIN equipamentos e ON e.idLocalidade = l.idLocalidade
        //         WHERE c.id="'.$cliente.'"
        //         GROUP BY c.cliente, l.localidade
        //         ');

        return DB::select("SELECT DISTINCT c.nome_cliente, l.nome_localidade, count(e.id_equipamento) as total FROM 
                          sgo_cliente c 
                          LEFT JOIN sgo_localidade l on l.id_cliente= c.id_cliente
                          LEFT JOIN sgo_equipamento e ON e.id_localidade = l.id_localidade
                          WHERE c.id_cliente='".$cliente."' GROUP BY c.nome_cliente, l.nome_localidade");
    }

    public function  getModelo($cliente)
    {
        //@Deprected alterado 08/04
        // return DB::select("SELECT distinct equipamentos.modelo
        //                             FROM equipamentos
        //                             WHERE exists
        //                             (
        //                                 SELECT  * FROM localidades l
        //                                 JOIN equipamentos e ON l.idLocalidade = e.idLocalidade
        //                                 JOIN clientes c ON l.idCliente = c.idCliente
        //                                 WHERE c.id=".$cliente.")
        //                         ");

        return DB::select("SELECT DISTINCT sgo_equipamento.modelo_equipamento FROM sgo_equipamento
                            WHERE exists 
                            (
                                SELECT * FROM sgo_localidade l 
                                JOIN sgo_equipamento e ON l.id_localidade = e.id_localidade
                                JOIN sgo_cliente c ON l.id_cliente = c.id_cliente
                                WHERE c.id_cliente='".$cliente."'
                            )");
    }

    public function  getSerial($cliente)
    {
        // return DB::select("SELECT distinct equipamentos.serial
        //                             FROM equipamentos
        //                             WHERE exists
        //                             (
        //                                 SELECT  * FROM localidades l
        //                                 JOIN equipamentos e ON l.idLocalidade = e.idLocalidade
        //                                 JOIN clientes c ON l.idCliente = c.idCliente
        //                                 WHERE c.id=".$cliente.")
        //                         ");

        return DB::select("SELECT DISTINCT sgo_equipamento.serial_equipamento FROM sgo_equipamento
            WHERE exists 
            (
                SELECT * FROM sgo_localidade l 
                JOIN sgo_equipamento e ON l.id_localidade = e.id_localidade
                JOIN sgo_cliente c ON l.id_cliente = c.id_cliente
                WHERE c.id_cliente='".$cliente."'
            )");                        
    }

    public function  getModeloByLocalidade($id_localidade)
    {
        //@Deprected alterado 08/04
        // return DB::select("SELECT distinct equipamentos.modelo
        //                             FROM equipamentos
        //                             WHERE exists
        //                             (
        //                                 SELECT  * FROM localidades l
        //                                 JOIN equipamentos e ON l.idLocalidade = e.idLocalidade
        //                                 WHERE l.localidade='".$localidade."')
        //                         ");

        return DB::select("SELECT distinct sgo_equipamento.modelo_equipamento 
                            FROM sgo_equipamento
                            WHERE EXISTS 
                            (
                                SELECT * FROM sgo_localidade l 
                                JOIN sgo_equipamento e ON l.id_localidade= e.id_localidade
                                WHERE l.id_localidade='".$id_localidade."'
                            )"
                        );
    }


    public function  getCentrosDeCusto($cliente)
    {
        return DB::table('users')->join('sgo_cliente','sgo_cliente.id_cliente','=','users.id_cliente')->value('cost_center');
    }

    public function  getSerialByLocalidade($id_localidade)
    {
         //@Deprected alterado 08/04
        // return DB::select("SELECT distinct e.serial FROM clientes c
        //             LEFT JOIN localidades l ON c.idCliente = l.idCliente
        //             LEFT JOIN equipamentos e ON l.idLocalidade = e.idLocalidade
        //            WHERE l.localidade='".$localidade."'  AND e.modelo!=''");
        return DB::select("SELECT distinct e.serial_equipamento FROM sgo_cliente c 
                           LEFT JOIN sgo_localidade l ON l.id_cliente=c.id_cliente
                           LEFT JOIN sgo_equipamento e ON l.id_localidade=e.id_localidade
                           WHERE l.id_localidade='".$id_localidade."' AND e.modelo_equipamento !=''");
    }

    public function  getInventarioDetalhes( $id_localidade)
    {
        //@Deprected alterado 08/04
        // return DB::table('equipamentos')
        //     ->selectRaw("equipamentos.*, localidades.endereco, localidades.cidade, localidades.estado ,suprimentos.nivel_suprimento, suprimentos.descricao, suprimentos.tipo, suprimentos.ultima_leitura ")
        //     ->join('localidades','localidades.idLocalidade','=','equipamentos.idLocalidade')
        //     ->join('clientes','clientes.idCliente','=','localidades.idCliente')
        //     ->leftjoin('suprimentos','suprimentos.numero_serie_impressora','=','equipamentos.serial')
        //     ->groupByRaw('equipamentos.idLocalidade, equipamentos.id,equipamentos.serial ,
        //                 localidades.id, suprimentos.nivel_suprimento, suprimentos.descricao, suprimentos.tipo ,suprimentos.ultima_leitura')
        //     ->where('localidades.localidade', '=', $localidade)
        //     ->orderByRaw('COALESCE(equipamentos.imagem,"") DESC ')
        //     ->paginate(config('pagination.DETAILS'));

        return DB::table('sgo_equipamento')
                ->selectRaw('sgo_equipamento.* ,
                             sgo_localidade.endereco_localidade, 
                             sgo_localidade.cidade_localidade, 
                             sgo_localidade.estado_localidade, 
                             sgo_suprimento.nivel_suprimento, 
                             sgo_suprimento.descricao_suprimento, 
                             sgo_suprimento.tipo_suprimento 
                             ')

                ->join('sgo_localidade','sgo_localidade.id_localidade','=','sgo_equipamento.id_localidade')

                ->join('sgo_cliente','sgo_cliente.id_cliente','=','sgo_localidade.id_cliente')

                ->leftJoin('sgo_suprimento','sgo_suprimento.id_equipamento','=','sgo_equipamento.id_equipamento')



                ->groupByRaw('sgo_equipamento.id_localidade, 
                              sgo_equipamento.id_equipamento, 
                              sgo_equipamento.serial_equipamento ,
                              sgo_localidade.id_localidade, 
                              sgo_suprimento.nivel_suprimento, 
                              sgo_equipamento.ultima_comunicao_equipamento,
                              sgo_suprimento.descricao_suprimento,
                              sgo_suprimento.tipo_suprimento')
                
                             ->where('sgo_localidade.id_localidade',"=",$id_localidade)
                ->orderByRaw('COALESCE(sgo_equipamento.imagem_equipamento,"") DESC ')             
                ->paginate(config('pagination.DETAILS'));
             
    }

    public function getSuprimentos($serial)
    {
        //@Deprected alterado 08/04
        #return DB::table('suprimentos')->where('numero_serie_impressora', '=', $serial)->orderByRaw('ultima_leitura DESC')->get();
        return DB::table('sgo_suprimento')
                ->join('sgo_equipamento','sgo_equipamento.id_equipamento','=','sgo_suprimento.id_equipamento')
                ->where('sgo_equipamento.serial_equipamento','=', $serial)
                ->orderByRaw('sgo_equipamento.ultima_comunicao_equipamento DESC')
                ->get();
    }

    public function getTrocas($id_equipamento)
    {
        //@Deprected alterado 08/04
        // return DB::table('trocas')
        //         ->join('suprimentos','suprimentos.numero_serie_impressora','=','trocas.serial_impressora')
        //         ->where('trocas.serial_impressora', '=', $serial)->orderByRaw('trocas.data_troca DESC')->get();

        return DB::table('sgo_suprimento_troca')
        ->where('sgo_suprimento_troca.id_equipamento','='.$id_equipamento)
        ->orderByRaw('sgo_suprimento_troca.data_criacao DESC')
        ->get();
                 
            
    }

    public function  getGraph($id_equipamento)
    {
        //@Deprected alterado 08/04

        // return DB::table('numeradores')
        //          ->selectRaw("* , numerador - LAG(numerador) OVER (PARTITION BY idEquipamento ORDER BY data) AS diferenca")
        //         ->where('serial_eqiuipamento', '=', $serial    )
        //         ->groupByRaw("DATE_FORMAT(`data`, '%m'), id")
        //         ->get();
        return DB::table('sgo_numerador')
        ->selectRaw('* , quantidade_numerador - LAG(quantidade_numerador) OVER (PARTITION BY id_equipamento ORDER BY data_numerador) AS diferenca')
        ->where('id_equipamento','=', $id_equipamento)
        ->groupByRaw('DATE_FORMAT(`data_numerador`, "%m"), id_numerador')
        ->get();

    }

    public  function  getTotais($id_equipamento)
    {
        return DB::table('sgo_numerador')
            ->selectRaw("data_numeador ,MAX(quantidade_numerador) as total ")
            ->where('id_equipamento', '=', $id_equipamento    )
            ->groupByRaw("id_equipamento , data_numerador")
            ->get();

    }

    public function getDetalhesSerial($id_equipamento)
    {
        return DB::table('sgo_equipamento')->where('id_equipamento','=',$id_equipamento)->orderByRaw('ultima_comunicao_equipamento DESC')->get();
    }


    public function getEquipamento($serial)
    {
        return DB::table('sgo_equipamento')->where('serial_equipamento','=',$serial)->get();
    }


    


}
