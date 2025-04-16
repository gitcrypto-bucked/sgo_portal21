@php($perm = new App\Policies\PagePolicy())
@php($perm->userCan( Route::currentRouteName()))
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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.14.1/themes/base/jquery-ui.min.css" integrity="sha512-TFee0335YRJoyiqz8hA8KV3P0tXa5CpRBSoM0Wnkn7JoJx1kaq1yXL/rb8YFpWXkMOjRcv5txv+C6UluttluCQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.14.1/themes/base/theme.min.css" integrity="sha512-lfR3NT1DltR5o7HyoeYWngQbo6Ec4ITaZuIw6oAxIiCNYu22U5kpwHy9wAaN0vvBj3U6Uy2NNtAfiaKcDxfhTg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel='stylesheet' href='https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css'>
    <link rel="stylesheet" href="{{asset('/css/style.css')}}">
    <link rel="stylesheet" href="{{asset('/css/dropdown.css')}}">
    <link rel="stylesheet" href="{{asset('/css/search.css')}}">
    <link rel="stylesheet" href="{{asset('/css/list.css')}}">
    <link rel="stylesheet" href="{{asset('/css/tracking.css')}}">
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.14.1/themes/base/jquery-ui.css">
    <link rel="stylesheet" href="{{asset('/css/sweetalert.cs    s')}}">

</head>
<body>
<!-- partial:index.partial.html -->
<div id="wrapper">
    <!--sidebar-->
    @include('components.sidebar')

    <!--sidebar-->
    <!--navbar -->
    @include('components.navwrapper')
    <!--content-->

    <div class="container-xxl mt-4 mobile ">
        <h2 class="content-title pageName">Tracking</h2>
        <p class="pageText"></p>
        @if($agent->isMobile()!=false)
                <div class="row gx-5 gy-3 mt-3 ">
                    <div>
                        <div class="col-md-8 details_header"   onclick="showModal()"  style="background-color: #ECECEC;
                                height: 80px;
                                padding: 18px;
                                border-radius: 1rem;
                                font-size: 15px !important;">
                            <ul class="list-inline ">
                                <li class="list-inline-item  px-2">Nota Fiscal:&nbsp;<strong class="px-2">{!! $pedido[0]->nfe_rastreamento !!}</strong> &nbsp;Status:&nbsp;
                                    <strong class="strong_status">
                                            @if( strtolower($pedido[0]->descricao_status_rastreamento)!="cancelado" && 
                                                 strtolower($pedido[0]->descricao_status_rastreamento)!='entregue'  &&
                                                 strtolower($pedido[0]->descricao_status_rastreamento)!='entrega cancelada' )
                                                 {!! "Em andamento" !!}
                                            @elseif(strtolower($pedido[0]->descricao_status_rastreamento)==="cancelado" || 
                                                    strtolower($pedido[0]->descricao_status_rastreamento)==='entrega cancelada')  
                                                {!! 'Cancelado' !!} 
                                            @elseif(strtolower($pedido[0]->descricao_status_rastreamento)=='entregue')
                                                {!! 'Entregue' !!}
                                            @endif         
                                    
                                        </strong>
                                     </li>
                                <li class="list-inline-item py-2 px-2">Rastreio:&nbsp;<strong class="strong_status">{!! strtoupper(htmlentities(str_replace('%3D','=',$pedido[0]->codigo_rastreamento))) !!}</strong> </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="container-xxl mt-4 mobile ">
                    <div class="row gx-3 mt-3">
                        <!-- gutters -->
                        <strong class="mb-3 strong_details">DADOS DA ENTREGA</strong>
                        <div class="col border rounded-4 bg-white">
                            <ul class="list-group p-4  " style="list-style: none; ">
                                <li class="item py-1" style="font-size: 14px !important"><strong>Responsável:&nbsp;</strong>{!! strtoupper($pedido[0]->responsavel_rastreamento) !!}</li>
                                <li class="item py-1 pb-1" style="font-size: 14px !important"><strong style="text-transform: none">Endereço de Entrega:&nbsp;</strong><p style="line-height: 1.1">{!! ucwords($pedido[0]->endereco_entrega_rastreamento) !!}, {!! strtoupper($pedido[0]->numero_entrega_rastreamento) !!}, {!! ucwords($pedido[0]->bairro_entrega_rastreamento) !!} , {{ \Helpers\Helpers::formatCidade($pedido[0]->cidade_entrega_rastreamento) }} - {!! ucwords($pedido[0]->estado_entrega_rastreamento) !!}, {!! \Helpers\Helpers::formatCEP($pedido[0]->cep_entrega_rastreamento) !!}</p></li>
                                <li class="item py-1" style="font-size: 14px !important"><strong>Data da Postagem:&nbsp;</strong> {!! date('d/m/Y', strtotime(str_replace('-','',$pedido[0]->data_faturamento_rastreamento))) !!}</li>
                                <li class="item py-1" style="font-size: 14px !important"><strong>Data da Entrega:&nbsp;</strong> {!! strlen($pedido[0]->data_entrega_rastreamento) ? date('d/m/Y', strtotime(str_replace('-','',$pedido[0]->data_entrega_rastreamento))) : '' !!}</li>
                                <li class="item py-1" style="font-size: 14px !important"><strong>Localidade:&nbsp;</strong> {!! ucfirst($pedido[0]->nome_localidade)!!}</li>
                            </ul>
                        </div>
                        <!-- gutters-->
                    </div>
                </div>
                <div class="container-xxl mt-4 mobile" >
                <div class="row mt-3">
                    <!-- gutters -->
                    <strong class="mb-3 strong_details">PRODUTO(S)</strong>
                    <br>
                    <div class="col-12 details_header"  style="background-color: transparent!important">
                        <ul class="list-inline">
                            <li class="w-100 d-flex justify-content-between">
                                <div>
                                    <strong>Código</strong>
                                </div>
                                <div>
                                    <strong>Descricão do Produto(s)</strong>
                                </div>
                            </li>
                        </ul>
                    </div>
                    <hr>
                    <table class="table_list">
                        @php($cod =0)
                        @for($i=0; $i<sizeof($pedido); $i++)
                            @if($cod != $pedido[$i]->codigo_produto_rastreamento)
                                <tr class="card my-2">
                                    <td class="w-100 d-flex justify-content-between card-header py-4">
                                        <div>
                                            <abbr  class="initialism px-2">{!! $pedido[$i]->codigo_produto_rastreamento !!}</abbr>
                                        </div>
                                        <div style="padding-left: 20px">
                                            <abbr  class="initialism ">{!!ucfirst(strtolower( $pedido[$i]->descricao_produto_rastreamento)    ) !!}</abbr>
                                        </div>

                                    </td>
                                </tr>
                            @endif
                            @php($cod = $pedido[$i]->codigo_produto_rastreamento)
                        @endfor
                    </table>
                    <!-- gutters-->
                </div>
        @else
        <div class="row gx-5 gy-3 mt-3 ">
            <div>
                <div class="col-md-8 details_header" >
                 
                    <ul class="list-inline ">
                        <li class="list-inline-item px-2">Nota Fiscal:&nbsp;<strong>{!! $pedido[0]->nfe_rastreamento !!}</strong></li>
                        <li class="list-inline-item px-4">Status:&nbsp;
                            <strong class="strong_status">
                                @if( strtolower($pedido[0]->descricao_status_rastreamento)!="cancelado" && 
                                     strtolower($pedido[0]->descricao_status_rastreamento)!='entregue'  &&
                                     strtolower($pedido[0]->descricao_status_rastreamento)!='entrega cancelada' )
                                     {!! "Em andamento" !!}
                                @elseif(strtolower($pedido[0]->descricao_status_rastreamento)==="cancelado" || 
                                        strtolower($pedido[0]->descricao_status_rastreamento)==='entrega cancelada')  
                                    {!! 'Cancelado' !!} 
                                @elseif(strtolower($pedido[0]->descricao_status_rastreamento)=='entregue')
                                    {!! 'Entregue' !!}
                                @endif         
                            </strong>
                        </li>
                        <li class="list-inline-item" onclick="showModal('{!! $pedido[0]->codigo_rastreamento !!}')">Rastreio&nbsp;
                                <strong class="strong_status">
                                    {!! strtoupper(htmlentities(str_replace('%3D','=',$pedido[0]->codigo_rastreamento))) !!}
                                </strong> </li>
                    </ul>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <!--table-->
    <div class="container-xxl mt-4 mobile ">
        <div class="row gx-3 mt-3">
            <!-- gutters -->
            <strong class="mb-3 strong_details">DADOS DA ENTREGA</strong>
            <div class="col border rounded-3 bg-white">
                <ul class="list-group p-4" style="list-style: none; ">
                    <li class="item py-2"><strong>Responsável:&nbsp;</strong>{!! strtoupper($pedido[0]->responsavel_rastreamento) !!}</li>
                    <li class="item py-2"><strong>Endereço de Entrega:&nbsp;</strong>{!! ucwords($pedido[0]->endereco_entrega_rastreamento) !!}, {!! strtoupper($pedido[0]->numero_entrega_rastreamento) !!}, {!! ucwords($pedido[0]->bairro_entrega_rastreamento) !!} , {{ \Helpers\Helpers::formatCidade($pedido[0]->cidade_entrega_rastreamento) }} - {!! ucwords($pedido[0]->estado_entrega_rastreamento) !!}, {!! \Helpers\Helpers::formatCEP($pedido[0]->cep_entrega_rastreamento) !!}</li>
                    <li class="item py-2"><strong>Data da Postagem:&nbsp;</strong> {!! date('d/m/Y', strtotime(str_replace('-','',$pedido[0]->data_faturamento_rastreamento))) !!}</li>
                    <li class="item py-2"><strong>Data da Entrega:&nbsp;</strong> @if(strpos($pedido[0]->data_entrega_rastreamento,'0000-00-00 00:00:00')===false) {!! date('d/m/Y', strtotime(str_replace('-','',$pedido[0]->data_entrega_rastreamento))) !!} @else{!! "----" !!} @endif</li>
                    <li class="item py-2"><strong>Localidade:&nbsp;</strong> {!! ucfirst($pedido[0]->nome_localidade)!!}</li>
                </ul>
            </div>
            <!-- gutters-->
        </div>
    </div>

    <div class="container-xxl mt-4 mobile  " >
        <div class="row mt-3">
            <!-- gutters -->
                <strong class="mb-3 strong_details">PRODUTO(S)</strong>
                <br>
                <div class="col-12 details_header"  style="background-color: transparent!important">
                    <ul class="list-inline">
                        <li class="w-100 d-flex justify-content-between">
                            <div>
                                <strong>Código</strong>
                            </div>
                            <div>
                                <strong>Descricão do Produto(s)</strong>
                            </div>
                            <div>
                                <strong>Quantidade</strong>
                            </div>

                        </li>
                    </ul>
                </div>
                <hr>
                <table class="table_list">
                    @php($cod =0)
                    @for($i=0; $i<sizeof($pedido); $i++)
                            @if($cod != $pedido[$i]->codigo_produto_rastreamento)
                                <tr class="card my-2">
                                    <td class="w-100 d-flex justify-content-between card-header py-4">
                                        <div>
                                            <abbr  class="initialism">{!! $pedido[$i]->codigo_produto_rastreamento !!}</abbr>
                                        </div>
                                        <div>
                                            <abbr  class="initialism">{!!ucfirst( $pedido[$i]->descricao_produto_rastreamento) !!}</abbr>
                                        </div>
                                        <div style="">
                                            <abbr title="HyperText Markup Language" class="initialism">{!! $pedido[$i]->quantidade_rastreamento !!}&nbsp;</abbr>
                                        </div>

                                    </td>
                                </tr>
                            @endif
                        @php($cod = $pedido[$i]->codigo_produto_rastreamento)
                    @endfor
                </table>
            <!-- gutters-->
        </div>
        @endif
    </div>
    <!--wrapper-->
    <!--modal -->
    <div class="modal modal-lg" tabindex="-1" id="myModal">
        <div class="modal-dialog">
            <div class="modal-content">

                <div class="modal-body">
                    <button type="button" class="btn-close float-end" data-bs-dismiss="modal" aria-label="Close"></button>
                    <!-- Tabs n avs -->
                        <iframe id='track' style="outline: none; border:none; width:100%; height:60vh" ></iframe>
                    <!-- end -->
                </div>
                <div class="modal-footer">
                </div>
            </div>
        </div>
    </div>

    <!--modal end-->
</div>
</body>
<script  src="{{asset('/js/script.js')}}"></script>
<script  src="{{asset('/js/main.js')}}"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js"
        integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy"
        crossorigin="anonymous"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<script src="https://code.jquery.com/ui/1.14.1/jquery-ui.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.i18n/1.0.9/jquery.i18n.js" integrity="sha512-OU7TUd3qODSbwnF5mHouW66/Yt54mzh58k+rxfJili7AunMl5wbF2D8kLGTGuUv5xM2MfylWZOPZaqOKpf7dZg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script>
function showModal(rastreamento)
{
    let url  = "https://app.tudoentregue.com.br/Tracking?Code="+rastreamento.replace("=", "%3D");
    document.getElementById('track').src = url;
    var appBanners = document.getElementsByClassName('tracking-header');

    for (var i = 0; i < appBanners.length; i ++) {
        appBanners[i].style.display = 'none';
    }
    $("#myModal").modal('toggle');
}
</script>
</html>
