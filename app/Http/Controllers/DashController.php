<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Auth;

use Illuminate\Http\Request;

class DashController extends Controller
{
    //
    public function postLogin(Request $request)
    {
        $paginate = Config::get('pagination.NEWS');
        
        $model = new \App\Models\NewsModel();
        $news =  $model->getAllNews(intval($paginate));
        unset($model);

        $model = new \App\Models\ChamadosModel();
        $abertos = $model-> getTotalAbertos(Auth::user()->id_cliente)[0]->abertos;
        $fechados = $model->getTotalFechados(Auth::user()->id_cliente)[0]->fechados;
        
        return view('dash')->with('news',$news)->with('abertos', $abertos)->with('fechados',$fechados);
    }
}
