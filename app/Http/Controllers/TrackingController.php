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
            return view('tracking')->with('track', $track);
        }
        else
        {
            $track = $model->getTracking(Auth::user()->id_cliente);
            return view('tracking')->with('track', $track);
        }
       
    }


    function getTrackingDetails(Request $request)
    {
        $model = new TrackingModel();
        $nfe_rastreamento = base64_decode($request->nfe_rastreamento);
        return view('tracking_detalhado')->with('pedido', $model->getTrackingDetails(intval($nfe_rastreamento)));
    }
}
