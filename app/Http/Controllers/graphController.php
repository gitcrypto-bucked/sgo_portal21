<?php

namespace App\Http\Controllers;

use App\Models\graphModel;
use Helpers\Helpers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
class graphController extends Controller
{
    public function getTotalFaturamento($idCliente,$periodo_fim= '2024-09-22', $json = false)
    {
        $model = new graphModel();
        $data = $model->getTotalFaturamento($idCliente, $periodo_fim);
        $st = date('Y-m-d', strtotime(str_replace('-', '/', $data[0]->periodo_inicio)));
        $end = date('Y-m-d', strtotime(str_replace('-', '/',$periodo_fim)));
        $dataset = (Helpers::getDatesFromRange($st, $end));
        $total = [0];
        array_push($total,  number_format((float)$data[0]->tot, 2, '.', '')  );
        if(!$json)
        {
            return ['total'=> $total , "label" => $dataset];
        }
        else if($json)
        {
            return  json_encode( ['status'=>200,'total'=> $total , "label" => $dataset]);
        }
    }

    public function  getPaginasMês($idCliente,  $periodo_fim= '2024-09-22',  $json = false)
    {

        $model = new graphModel();
        $data = $model->getTotalPrint($idCliente, $periodo_fim);
        $total  = [0];
        array_push($total, $data[0]->impresso);

        if(!$json)
        {
            return ['paginas'=> $total, 'periodo'=> date('M-Y', strtotime(str_replace('-','/',$periodo_fim)))];
        }
        else if($json)
        {
            return  json_encode(['status'=>200,'paginas'=> $total, 'periodo'=> date('M-Y', strtotime(str_replace('-','/',$periodo_fim)))]);
        }
    }


   public function getChamadosGraph($idCliente, $periodo_inicio='09-23-24', $periodo_fim= '10-22-24', $json = false)
   {
       $model = new graphModel();
       $data = $model->getDataChamados($idCliente, $periodo_inicio, $periodo_fim);
       $dentro =[];
       $fora = [];
       $dataset = [];
       $st = date('Y-m-d', strtotime(str_replace('-', '/', $periodo_inicio)));
       $end = date('Y-m-d', strtotime(str_replace('-', '/',$periodo_fim)));
       $dataset = (Helpers::getDatesFromRange($st, $end));
       for($i = 0; $i < count($data); $i++)
       {
           array_push($fora, (floatval($data[$i]->FORA)));
           array_push($dentro, floatval($data[$i]->DENTRO));
       }
       if(!$json)
       {
           return [$fora,  $dentro, $dataset ];
       }
       else if($json)
       {
           return  json_encode(['status'=>200, $fora,  $dentro, [ date('d/m/Y', strtotime(str_replace('-', '/', $periodo_inicio))) ,
               date('d/m/Y', strtotime(str_replace('-', '/',$periodo_fim))) ]]);
       }
   }


   public function getSLADentroPercent($idCliente, $periodo_inicio='2024-09-22', $periodo_fim= '2024-10-22', $json = false)
   {
       $model = new graphModel();
       $data = $model->getSLADentroPercent($idCliente, $periodo_fim);
       $st = date('M-Y', strtotime(str_replace('-', '/',$periodo_inicio)));
       $end = date('M-Y', strtotime(str_replace('-', '/' , $periodo_fim)));
       $dataset = (Helpers::getDatesFromRange($st, $end));
       $total = [0];
       $target = [floatval(config('sla.TARGET'))];
       for($i = 0; $i < count($data); $i++)
       {
           array_push($total, $data[$i]->percent  );
           array_push($target, floatval(config('sla.TARGET')));
       }
       if(!$json)
       {
           return [$dataset, $target, $total];
       }
       else if($json)
       {
           return  json_encode(['status'=>200,'dataset'=>$dataset,'target'=> $target,'total'=> $total]);
       }
   }





}
