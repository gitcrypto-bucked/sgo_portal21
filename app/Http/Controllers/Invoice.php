<?php

namespace App\Http\Controllers;

use App\Models\InvoiceModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

ini_set('memory_limit', '-1');
set_time_limit(0);
class Invoice extends Controller
{
    public function index()
    {
        return view('invoice-upload');
    }

    public function uploadInvoice(Request $request)
    {
        if ($request->file('ffile')->getClientOriginalExtension()==="csv" )
        {
            $data = null;
            $file = $request->file('ffile');
            $fileExtension = $file->getClientOriginalExtension();
            if(str_contains(strtolower($file->getClientOriginalName()),'faturamento')!=true)
            {
                return redirect('/invoice-upload')->with('error','Arquivo invalido');
            }
            switch ($fileExtension)
            {
                case 'csv':
                    $data = [];
                    $file = fopen($request->file('ffile'), "r");
                    while(! feof($file))
                    {
                       $data[]= fgetcsv($file);
                    }
                    fclose($file);
                    event(new \App\Events\ImportInvoiceCSV($data, Auth::user()->email));
                    return redirect('/invoice-upload')->with('sucess','O Arquivo anexo será processado, enviaremos um e-mail ao terminar.');
                break;
                default :
                    return view('invoice-upload')->with('error','Arquivo invalido');

            }
        }
        else
        {
            return view('invoice-upload')->with('error','Arquivo invalido');
        }

    }


    public function getFaturamento(Request $request)
    {
        $model = new InvoiceModel();
        $invoice = $model->select(Auth::user()->id_cliente);
        return view('invoice')->with('invoice',$invoice);
    }

    public function  getDetailsFaturamento(Request $request)
    {
        $model = new InvoiceModel();

        $periodo_inicio = base64_decode( $request->input('periodo_cobranca_inicio'));
        $periodo_fim = base64_decode( $request->input('periodo_cobranca_fim'));
        $total = base64_decode( $request->input('total'));

        $model = new InvoiceModel();

        $invoices = $model->getDetalhes(Auth::user()->id_cliente,$periodo_inicio,$periodo_fim,$total);
        return view('invoice_details')->with('invoice',$invoices)->with('periodo_inicio',$periodo_inicio)->with('periodo_fim',$periodo_fim)->with('total',$total);
    }

    public function getDashFaturamento(Request $request)
    {
        #$controller = new graphController();
        #$fat = $controller->getTotalFaturamento(Auth::user()->cliente);
        #$pag = $controller->getPaginasMês(Auth::user()->cliente);
        //->with('datasets' , $fat['label'])->with('total',$fat['total'])->with('paginas',$pag['paginas'])->with('periodo',$pag['periodo']);
        return view('dashboard_invoice');
    }


    public function getFaturamentoDetalhesEquipamento(Request $request)
    {

        $id_equipamento = $request->id_equipamento;
        
        $model = new InvoiceModel();

        $cobrado = $model->getTotalCobrado($id_equipamento);
      

        $invoices = $model->getDetalhesEquipamento($id_equipamento);
        $invoices = json_decode($invoices,true);
        if(empty($invoices) )
        {
            return json_encode(['st'=>300,'msg'=>'Não foram encontrados dados para este equipamento']);
        }
        else
        {
            return json_encode(['st'=>200, 'data'=>$invoices,'periodo_inicio'=>date('d/m/Y',strtotime($invoices[0]['periodo_cobranca_inicio'])), 'periodo_fim'=>date('d/m/Y',strtotime($invoices[0]['periodo_cobranca_fim'])),'total'=>$cobrado ]);
        }
       
    }



}
