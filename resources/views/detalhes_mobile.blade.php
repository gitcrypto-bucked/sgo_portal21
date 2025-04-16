<!DOCTYPE html>
<html lang="pt_BR" >
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="Ti team &amp; Low Cost contributors">
    <meta name="generator" content="Pedro Henrique & Washington">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Portal LowCost </title>
    <!--  <link rel='stylesheet' href='https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css'>-->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
          integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH"
          crossorigin="anonymous">
    <link rel='stylesheet' href='https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css'>
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">


    <link rel="stylesheet" href="{{asset('/css/style.css')}}">
    <link rel="stylesheet" href="{{asset('/css/dropdown.css')}}">
    <link rel="stylesheet" href="{{asset('/css/search.css')}}">
    <link rel="stylesheet" href="{{asset('/css/list.css')}}">

    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/css/select2.min.css" rel="stylesheet" />
    <style>
        .select2-container .select2-selection--single{
            height:34px !important;
        }
        .select2-container--default .select2-selection--single{

        }

        .btn_link, .btn_link:hover, .btn_link:active {
            border: none !important;
            outline: none !important;
            background-color: transparent !important;
        }
        .link, .link:hover, .link:visited {
            font-family: 'Poppins', sans-serif !important;
            font-size: 12px !important;
            color: #2079fe !important;
            font-weight: 550;
            text-decoration: underline !important;
            line-height: 0 !important;
            cursor: pointer !important;
        }

        .right {
            position: relative;
            background: #edde9a;
            -webkit-border-radius: 10px;
            -moz-border-radius: 10px;
            border-radius: 10px;
            height: 134px;
            width:90%;
            margin-top: 120px;

        }

        .left:before{
            content: "";
            position: absolute;
            top: 60px;
            right:-30px;
            z-index: 1;
            border: solid 15px transparent;
            border-right-color: #edde9a;
        }

        .left {
            position: relative;
            background:#edde9a;
            -webkit-border-radius: 10px;
            -moz-border-radius: 10px;
            border-radius: 10px;
            height: 134px;
            margin-top: 120px;

        }

        .right:before{
            content: "";
            position: absolute;
            top: 60px;
            left:-30px;
            z-index: 1;
            border: solid 15px transparent;
            border-right-color: #edde9a;
        }



        .right_alert{
            position: relative;
            background: #2e8bc0;
            -webkit-border-radius: 10px;
            -moz-border-radius: 10px;
            border-radius: 10px;
            height: 130px;
            width:90%;
            margin-top: 120px;
        }

        .right_alert:before{
            content: "";
            position: absolute;
            top: 60px;
            right:-29px;
            z-index: 1;
            border: solid 15px transparent;
            border-right-color: #2e8bc0;
            transform: rotate(180deg);
        }


        .left {
            position: relative;
            background:#edde9a;
            -webkit-borde-rradius: 10px;
            -moz-border-radius: 10px;
            border-radius: 10px;
            height: 134px;
            width:90%;

        }

        .left:before{
            content: "";
            position: absolute;
            top: 60px;
            right:-29px;
            z-index: 1;
            border: solid 15px transparent;
            border-right-color: #edde9a;
            transform: rotate(180deg);
        }

        td
        {
            border-bottom: none !important;
        }


    </style>
</head>

<body id="wrapper">
<!--sidebar-->
@include('components.sidebar')

<!--sidebar-->
<!--navbar -->
@include('components.navwrapper')
<!--content-->
<div class="container-xxl mt-4 mobile  mb-4">
    <h2 class="content-title pageName">Detalhes do equipamento</h2>
    <div class="container-xxl mt-4 mobile ">
        <div class="row">
            <div class="col">
            @for($i=0; $i<sizeof($inventario); $i++)
                <div class="card" style="width: auto;">
                    <div class="card-body">
                        <h5 class="card-title" style="font-weight: 550!important;">{!! ucwords(strtolower( $inventario[$i]->modelo)) !!}</h5>
                        <ul class="card-text mb-2 py-2" style="list-style: none">
                            <li class="py-1">N° de Série: {!! (strtoupper( $inventario[$i]->serial)) !!}</li>
                            <li class="py-1">IP do Equipamento: {!! strlen(@$inventario[$i]->endereco_ip) ? $inventario[$i]->endereco_ip : "0.0.0.0" !!}</li>
                            <li class="py-1">Centro de Custo: {!! strlen( @$inventario[$i]->cdc)?  @$inventario[$i]->cdc : 'C.D.C'  !!}</li>
                            <li class="py-1">Situação: {!! strlen($inventario[$i]->situacao)? $inventario[$i]->situacao: 'Impressora sem comunicação com o PrintWayy' !!}</li>
                        </ul>
                        <ul class="card-text mb-2 py-2" style="list-style: none">
                            <li class="py-1">N° Contrato: @if($inventario[$i]->ncontrato==""){!! "LC20250109M-01700" !!}@else{!! (strtoupper( $inventario[$i]->ncontrato)) !!}@endif</li>
                            <li class="py-1">Início Contrato: {!!  strlen($inventario[$i]->data_inicio)? date('d/m/Y', strtotime(str_replace('-','/',$inventario[$i]->data_inicio)))  : '01/01/2025' !!}</li>
                            <li class="py-1">Término Contrato: {!!  strlen($inventario[$i]->data_fim)? date('d/m/Y', strtotime(str_replace('-','/',$inventario[$i]->data_fim)))  :  "01/12/2028"!!}</li>
                            <li class="py-1">Nível Suprimentos: {!!  strlen(@$inventario[$i]->nivel_suprimento)? @$inventario[$i]->nivel_suprimento."%" : '-----' !!}</li>
                        </ul>
                        <ul class="card-text mb-2 py-2" style="list-style: none">
                            <li class="py-1">Endereço: {!! strlen(strtolower(@$inventario[$i]->endereco)) ? ucfirst(strtolower(@$inventario[$i]->endereco)) : "Rua das Tordesilhas"!!}</li>
                            <li class="py-1">Telefone: {!! strlen(@$inventario[$i]->telefone) ? @$inventario[$i]->telefone : "(11) 99999-9999" !!}</li>
                            <li class="py-1">Colaborador: {!! strlen(@$inventario[$i]->colaborador) ? @$inventario[$i]->colaborador : "Bud Spencer" !!}</li>
                        </ul>
                        <ul class="card-text mb-2 py-2" style="list-style: none">
                            <li class="py-1">Cidade: {!! strlen(strtolower(@$inventario[$i]->cidade))? ucfirst(\Helpers\Helpers::formatCidade(strtolower(@$inventario[$i]->cidade))) : "São Paulo" !!}</li>
                            <li class="py-1">UF: {!! strlen(@$inventario[$i]->uf)? @$inventario[$i]->uf : "SP" !!} </li>
                            <li class="py-1">E-mail: {!! strlen(@$inventario[$i]->email)? @$inventario[$i]->email : "bud.spencer@gerdau.com" !!}</li>
                            <li class="py-1">Departamento: {!! strlen(@$inventario[$i]->departamento) ? @$inventario[$i]->departamento : "Administração" !!}<</li>
                        </ul>
                        </div>
                    @if( $inventario[$i]->imagem!=null ||  $inventario[$i]->imagem!='')
                        <img src="{!! $inventario[$i]->imagem !!}" class="card-img-top" alt="..." >
                    @else
                        <img src="{{ asset('img/no_image.png') }}" class="card-img-top" alt="..."  style="opacity: 0.7 !important">
                    @endif
                    <a class="btn  btn-primary">Detalhes da impressora </a>
                </div>
            @endfor
            </div>
        </div>
    </div>
    <div class="container-xxl mt-4 mobile ">
        <div class="col" >
        <canvas id="print"  ></canvas>
        </div>
    </div>
    <div class="container-xxl mt-4 mobile " id="detalhes">
        <p class="btn-nav mt-4  text-center">Suprimento</p>
        <table class="table table-striped mb-3 px-2" id="suprimentos">
            <thead>
            <tr>
                <th scope="col" class="text-center">Descrição</th>
                <th scope="col" colspan="2" class="text-center">Nivel informado </th>
                <th scope="col" class="text-center">Última Leitura</th>
            </tr>
            </thead>
            <tbody>
                @for($i=0; $i<count($suprimentos); $i++)

                        <tr>
                            <td class="text-center">
                                {!! $suprimentos[$i]->descricao !!}
                            </td>
                            <td class="text-center" colspan="2">
                                {!! $suprimentos[$i]->nivel_suprimento !!}
                            </td>
                            <td class="text-center">
                                {!! $suprimentos[$i]->ultima_leitura !!}
                            </td>
                        </tr>

                @endfor
            </tbody>
        </table>

        <p class="btn-nav mt-4 text-center">Contadores Gerais</p>
        <table class="table table-striped mb-3" id="totais">
            <thead>
            <tr>
                <th scope="col" colspan="2" class="text-center">Total</th>
                <th scope="col" class="text-center">Última Leitura</th>
            </tr>
            @for($i =0; $i<count($totais); $i++)
                <tr>
                    <td class="text-center" colspan="2">
                            {!! number_format($totais[$i]->total)!!}
                    </td>
                    <td class="text-center" colspan="2">
                        {!! $totais[$i]->data!!}
                    </td>
                </tr>
            @endfor
            </thead>

        </table>
        <a class="btn  btn-primary" onclick="window.history.back()" >Voltar</a>
    </div>
</div>
<script  src="{{asset('/js/script.js')}}"></script>
<script  src="{{asset('/js/main.js')}}"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js"
        integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy"
        crossorigin="anonymous"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js"></script>
<script src="
https://cdn.jsdelivr.net/npm/chart.js@4.4.7/dist/chart.umd.min.js
"></script>
<script>
    window.onload = function (){
        showGraph();
    };
    function showGraph()
    {
        if(myChart!=null){
            myChart.destroy();
        }
        const data = {
            labels: @json($meses),
            datasets: [{
                label: 'Total de páginas',
                data: @json($differences),
                fill: false,
                borderColor: 'rgb(75, 192, 192)',
                tension: 0.1,
                responsive:true
            }]
        };
        const config = {
            type: 'line',
            data: data,
        };
        var ctx = document.getElementById("print");
        var myChart = new Chart(ctx,config);

    }
</script>
</body>
</html>

