<?php

namespace App\Http\Controllers;

use App\Models\InventarioModel;
use App\Models\LocalidadeModel;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;

class Inventario extends Controller
{
    public function getInventario()
    {
        $model = new InventarioModel();
        $inventario = $model->getInventory(Auth::user()->id_cliente);
        $localidades = $model->getLocalidades(Auth::user()->id_cliente);
        $modelo = $model->getModelo(Auth::user()->id_cliente);
        $serial = $model->getSerial(Auth::user()->id_cliente);
        return view('inventario')->with('inventario', $inventario)->with('localidades', $localidades)->with('modelo', $modelo)->with('serial', $serial);
    }


    public function getInventarioDetails(Request $request)
    {
        $id_localidade = base64_decode($request->id_localidade);

        $model = new InventarioModel();
        $modelo = $model->getModeloByLocalidade($id_localidade);
        $serial = $model->getSerialByLocalidade($id_localidade);
        $cdc = $model->getCentrosDeCusto(Auth::user()->id_cliente);

        $inventario = $model->getInventarioDetalhes($id_localidade);
        unset($model);
        
        $model= new LocalidadeModel();
        $localidade = $model->getLocalidadeById($id_localidade)[0]->nome_localidade;

        return view('inventario_details')->with('id_localidade', $id_localidade)
                                         ->with('inventario',$inventario)
                                         ->with('localidade',$localidade)
                                         ->with('modelo', $modelo)
                                         ->with('serial', $serial)
                                         ->with('cdc', $cdc);
    }

    public function getSuprimentos(Request $request)
    {
        $model = new InventarioModel();
        $serial = $model->getSuprimentos($request->id_equipamento);
        return json_encode(['status' => 200, 'data' => $serial]);
    }


    public function getMonitoramentos(Request $request)
    {
        $model = new InventarioModel();
        $data = $model->getTrocas($request->id_equipamento);
        return json_encode(['status' => 200, 'data' => $data]);
    }


    public function  getContatores(Request $request)
    {
        $model = new InventarioModel();
        $data = $model->getGraph($request->id_equipamento);
        $total_impressao =[];
        $meses= [];
        for($i = 0; $i < count($data); $i++)
        {
            if($data[$i]->diferenca> 0)
            {
                array_push($total_impressao,$data[$i]->diferenca);
                array_push($meses,date("d/m",strtotime($data[$i]->data)));
            }
            else
            {
                #array_push($total_impressao,0);
            }
        }

        $differences=[];
        for($i=0;$i<count($total_impressao);$i++){
            for($j=$i+1;$j<count($total_impressao);$j++){
                $differences[]=abs($total_impressao[$i]-$total_impressao[$j]);
            }
        }
        #print_r($differences);
        #print_r($meses);

        return json_encode(['status' => 200, 'data' => $differences, 'meses' => $meses]);
    }


    public function getTotais(Request $request)
    {
        $model = new InventarioModel();
        $data = $model->getTotais($request->serial);
        $value = $data->max();
        return json_encode(['status' => 200, 'data' => $value]);
    }

    public function  getDetalhesMobile(Request $request)
    {
        $serial = base64_decode($request->id_equipamento);
        $model = new InventarioModel();
        $data = $model->getGraph($serial);
        $total_impressao =[];
        $meses= [];
        for($i = 0; $i < count($data); $i++)
        {
            if($data[$i]->diferenca> 0)
            {
                array_push($total_impressao,$data[$i]->diferenca);
                array_push($meses,date("d/m",strtotime($data[$i]->data)));
            }
            else
            {
                #array_push($total_impressao,0);
            }
        }

        $differences=[];
        for($i=0;$i<count($total_impressao);$i++){
            for($j=$i+1;$j<count($total_impressao);$j++){
                $differences[]=abs($total_impressao[$i]-$total_impressao[$j]);
            }
        }

        $trocas = $model->getTrocas($serial);
        $suprimentos = $model->getSuprimentos($serial);
        $inventario = $model->getDetalhesSerial($serial);
        $totais = $model->getTotais($serial);
        return view('detalhes_mobile')->with('inventario', $inventario)->with('trocas',$trocas)
            ->with('suprimentos',$suprimentos)->with('totais',$totais)->with('differences',$differences)
            ->with('meses',$meses)->with('serial',$serial);
    }
}
