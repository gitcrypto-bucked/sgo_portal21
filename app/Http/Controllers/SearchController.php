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

        $id_cliente = $model->getIDCliente($cliente)[0]->id_cliente;

        $id_localidade = $model->getIDLocalidade($localidade)[0]->id_localidade;

        if($id_cliente !=null && $id_localidade!=null)
        {
            $inventario = $model->searchInventario($id_cliente,$id_localidade);
        }

        unset($model);

        $model = new InventarioModel();

        $modelo = $model->getModeloByLocalidade($id_localidade);
        $serial = $model->getSerialByLocalidade($id_localidade);
        $cdc = $model->getCentrosDeCusto(Auth::user()->cliente);
        return view('inventario')->with('inventario', $inventario)->with('localidades', $localidade);
    }


    public function buscaInventarioDetalhado(Request $request)
    {

        $cliente = $request->cliente;
        $localidade = $request->localidade;
        $modelo = $request->modelo;
        $serial = $request->serial;
      
        $model  = new SearchModel();

        $id_cliente = $model->getIDCliente($cliente)[0]->id_cliente;

        $id_localidade = $model->getIDLocalidade($localidade)[0]->id_localidade;

        $inventario = $model->searchInventarioDetalheWithModelo($serial,$id_localidade);
        

        unset($model);

        $model = new InventarioModel();
        $modelos = $model->getModeloByLocalidade($id_localidade);
        $serials = $model->getSerialByLocalidade($id_localidade);
        $cdc = $model->getCentrosDeCusto(Auth::user()->cliente);
        return view('inventario_details')
               ->with('inventario', $inventario)
               ->with('modelo',$modelos)
               ->with('localidade', $localidade)
               ->with('serial', $serial)
               ->with('cdc', $cdc)
               ->with('model',$modelo);
    }
}
