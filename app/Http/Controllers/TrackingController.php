<?php

namespace App\Http\Controllers;

use App\Models\TrackingModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TrackingController extends Controller
{
    function getTracking(Request $request)
    {
        $model = new TrackingModel();
        if(isset($request->id_equipamento))
        {
            $id_equipamento = base64_decode($request->id_equipamento);
            $track = $model->getTrackingEquipamento($id_equipamento);
            unset($model);

            $model = new \App\Models\LocalidadeModel();
            $localidades = $model->getLocalidadeByIdEquipamento($id_equipamento);
            unset($model);
            return view('tracking')->with('track', $track)->with('localidade',$localidades);
        }
        else
        {
            $track = $model->getTracking(Auth::user()->id_cliente);
            unset($model);

            $model = new \App\Models\LocalidadeModel();
            $localidades =  $model->getLocalidadeByCliente(Auth::user()->id_cliente);
            unset($model);

            return view('tracking')->with('track', $track)->with('localidade',$localidades);
        }
       
    }


    function getTrackingDetails(Request $request)
    {
        $model = new TrackingModel();
        $nfe_rastreamento = base64_decode($request->nfe_rastreamento);
        return view('tracking_detalhado')->with('pedido', $model->getTrackingDetails(intval($nfe_rastreamento)));
    }
}
