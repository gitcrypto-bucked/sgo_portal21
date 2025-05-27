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
    <link rel='stylesheet' href='https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css'>
    <link rel="stylesheet" href="{{asset('/css/style.css')}}">
    <link rel="stylesheet" href="{{asset('/css/dropdown.css')}}">
    <link rel="stylesheet" href="{{asset('/css/search.css')}}">
    <link rel="stylesheet" href="{{asset('/css/list.css')}}">
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
        <h2 class="content-title pageName" style="color: {!! \Helpers\Helpers::getTextClienteColor(Auth::user()->id_cliente)!!} !important">Listagem - Faturamento</h2>
        <p class="pageText">Veja abaixo todos os equipamentos e serviços que você possui com a LowCost. Utilzie a busca para encontrar os itens especificos!</p>
        @if($agent->isMobile()!=false)
           <!--mobile-->
            <form method="POST">
                <div class="row gx-5 gy-3 mt-3 ">
                    <div class="col-md-6">
                        <label for="filter" class="form-label ">Buscar</label>
                        <input type="text" class="form-control" id="filter">
                    </div>
                    <div class="col-mg-6" >
                        <label for="filter"  class="form-label ">Ordernar por:</label>
                        <select class="form-control" >
                            <option>Menor Data</option>
                        </select>
                    </div>
                    <div class="col-md-6" >
                        <button type="button" class="btn btn-primary float-end">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-search" viewBox="0 0 16 16">
                                <path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001q.044.06.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1 1 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0"></path>
                            </svg>
                            Buscar
                        </button>
                    </div>
                </div>
            </form>
             </div>
            <!--table-->
            <div class="container-xxl mobile">
                <table class="table_list">
                    @for($i=0; $i<sizeof($invoice); $i++)
                        <tr class="card my-2" >
                            <td class="card-header d-flex justify-content-between" >
                                <div style="width: 33%">
                                    <div class="text-secondary">Localidade</div>
                                    <abbr title="HyperText Markup Language" class="initialism" style="  word-break: break-all;">{!! strtoupper($invoice[$i]->localidade) !!}</abbr>
                                </div>
                                <div style="width: 18%">
                                    <div class="text-secondary">Serial</div>
                                    <abbr title="HyperText Markup Language" class="initialism" style="  word-break: break-all;">{!! strtoupper($invoice[$i]->serial) !!}</abbr>
                                </div>

                                <div style="width: 15%">
                                    <div class="text-secondary">Vol. Página</div>
                                    <div class="green"><abbr title="HyperText Markup Language" class="initialism">{!! (floatval($invoice[$i]->cobrado)) !!}</abbr></div>
                                </div>
                                <div >
                                    <div class="text-secondary px-1">Vol. Total</div>
                                    <div class="green"><abbr title="HyperText Markup Language" class="initialism">{!!'R$ '.number_format($invoice[$i]->cobrado,2,",","."); !!}</abbr></div>
                                </div>
                            </td>
                        </tr>
                    @endfor
                </table>
            </div>

            <div class="container-xxl mt-4 mobile ">
                <div class="row">
                    <div  class='col-sm-4'>
                        @if($invoice instanceof \Illuminate\Pagination\AbstractPaginator)
                            {{$invoice->withQueryString()->links()}}
                        @endif
                    </div>
                </div></div>
            <!--mobile-->
        @else
        <div class=" container-xxl mt-2 " style="padding-right:  0px !important; padding-left: 0px!important">
           <div class="col">
               <p class="initialism_alt float-start">Periodo de cobrança: {!! date( "d/m/Y", strtotime(str_replace('-','/',$periodo_inicio))).' - '.date( "d/m/Y", strtotime(str_replace('-','/',$periodo_fim))); !!} </p>
           </div>
           <div class="col">
               <p class="initialism_alt float-end">Saldo: {!!number_format($total,2,",",".") !!}</p>
           </div>
        </div>
            <br>
            <form method="POST">
            <div class="row gx-5 gy-3 mt-3 ">
                <div class="col-8">
                    <label for="filter">Buscar:</label>
                    <input type="text" class="form-control" id="filter">
                </div>
                <div class="col-4">
                    <label for="filter">Ordernar por:</label>
                    <select class="form-control" >
                        <option>Menor Data</option>
                    </select>
                </div>
            </div>
        </form>
        </div>

    <div class="container-xxl mt-4 mobile ">
        <div class="row">
            <table class="table_list">
                @for($i=0; $i<sizeof($invoice); $i++)
                   <tr class="card my-2">
                        <td class="w-100 d-flex justify-content-between card-header py-4 px-4" style=" box-shadow: horizontal-offset vertical-offset blur-radius spread-radius color inset;">
                            <div>
                                <div class="text-secondary">Localidade</div>
                                <abbr title="HyperText Markup Language" class="initialism">{!! strtoupper($invoice[$i]->nome_localidade) !!}</abbr>
                            </div>
                            <div style="align-items: start !important">
                                <div class="text-secondary">Serial</div>
                                <abbr title="HyperText Markup Language" class="initialism">{!! strtoupper($invoice[$i]->serial_equipamento) !!}</abbr>
                            </div>
                            <div style="float: right !important">
                                <div class="text-secondary">Login</div>
                                <abbr title="HyperText Markup Language" class="initialism">{!!  $invoice[$i]->login_faturamento !!}</abbr>
                            </div>
                            <div style="float: right !important">
                                <div class="text-secondary">Grupo de Serviço</div>
                                <abbr title="HyperText Markup Language" class="initialism">{!!  $invoice[$i]->grupo_descricao_servico_faturamento !!}</abbr>
                            </div>
                            <div style="float: right !important">
                                <div class="text-secondary">C.D.C</div>
                                <abbr title="HyperText Markup Language" class="initialism">{!!  $invoice[$i]->cdc_faturamento !!}</abbr>
                            </div>
                            <div style="float: right !important">
                                <div class="text-secondary">Val. Cobrado</div>
                                <abbr title="HyperText Markup Language" class="initialism">{!!  sprintf('%0.2f',(floatval($invoice[$i]->cobrado_faturamento))) !!}</abbr>
                            </div>                            
                            <div style="float: right !important">
                                <div class="text-secondary">Qtd. Duplex</div>
                                <abbr title="HyperText Markup Language" class="initialism">{!!   sprintf('%0.4f',(floatval($invoice[$i]->quantidade_duplex_faturamento))) !!}</abbr>
                            </div>
                            <div style="float: right !important">
                                <div class="text-secondary">Val. Unitário</div>
                                <abbr title="HyperText Markup Language" class="initialism">{!!  "R$ ".sprintf('%0.4f',(floatval($invoice[$i]->valor_unitario_faturamento))) !!}</abbr>
                            </div>                       
                            <div style="float: right !important">
                                <div class="text-secondary">Val. Total</div>
                                <abbr title="HyperText Markup Language" class="initialism">{!!  "R$ ".$invoice[$i]->valor_total_geral_faturamento !!}</abbr>
                            </div>
                        </td>
                    </tr>

                @endfor
            </table>
        </div>
    </div>
    <div class="container-xxl mt-4 mobile ">
        <div class="row">
            <div  class='col-lg-8'>
                @if($invoice instanceof \Illuminate\Pagination\AbstractPaginator)
                    {{$invoice->withQueryString()->links()}}
                @endif
            </div>
        </div></div>
    <!--wrapper-->
    @endif
</div>
</body>
<script  src="{{asset('/js/script.js')}}"></script>
<script  src="{{asset('/js/main.js')}}"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js"
        integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy"
        crossorigin="anonymous"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>

<script>

</script>
</html>
