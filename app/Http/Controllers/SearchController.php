<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SearchModel  ;
use App\Models\InventarioModel;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;


class SearchController extends Controller
{
    public function buscaInventario(Request $request)
    {
        $cliente= $request->input('cliente');
        $localidade = strlen($request->input('localidade')) ? $request->input('localidade') : null;

        $model = new SearchModel();
        $inventario = $model->searchInventario($cliente,$localidade);
        unset($model);
         $model = new InventarioModel();

        $modelo = $model->getModeloByLocalidade($localidade);
        $serial = $model->getSerialByLocalidade($localidade);
        $cdc = $model->getCentrosDeCusto(Auth::user()->cliente);
        return view('inventario')->with('inventario', $inventario)->with('localidades', $localidade);

    }


    public function buscaInventarioDetalhado(Request $request)
    {
        $modeloo = $request->input('modelo');
        $localidade = $request->input('localidade');
        $model  = new SearchModel();
        $inventario = $model->searchInventarioDetalheWithModelo($localidade,$modeloo);
        unset($model);
        $model = new InventarioModel();
        $modelo = $model->getModeloByLocalidade($localidade);
        $serial = $model->getSerialByLocalidade($localidade);
        $cdc = $model->getCentrosDeCusto(Auth::user()->cliente);
        return view('inventario_details')->with('inventario', $inventario)->with('modelo',$modelo)->with('localidade', $localidade)->with('serial', $serial)->with('cdc', $cdc)->with('model',$modeloo);
    }
}
