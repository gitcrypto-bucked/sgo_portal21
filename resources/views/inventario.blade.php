@php($perm = new App\Policies\PagePolicy())
@php($perm->userCan( Route::currentRouteName()))
    <!DOCTYPE html>
<html lang="pt_BR" >
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="Ti team &amp; Low Cost contributors">
    <meta name="generator" content="Pedro Henrique & Deus">
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
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/css/select2.min.css" rel="stylesheet" />
    <style>
        .select2-container .select2-selection--single{
            height:34px !important;
        }
        .select2-container--default .select2-selection--single{

        }

    </style>
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

    <div class="container-xxl mt-4 mobile mb-4">
        <h2 class="content-title pageName">Inventário de Equipamentos e Serviços</h2>
        <p class="pageText">Veja abaixo todos os equipamentos e serviços que você possui com a LowCost. Utilzie a busca para encontrar os itens especificos!</p>

        @if($agent->isMobile()!=false)
            <!--mobile-->
                <!--search -->
                <div class="row gx-2 gy-2 mt-3 ">
                <form method="POST" action="{!! route('busca_invetario') !!}" class="row g-3">
                    @csrf
                    <div class="col-md-6">
                        <label for="cliente" class="form-label d-none d-lg-block">Cliente</label>
                        <select  class="form-control select2" id="cliente" name="cliente" data-hide-disabled="true" data-actions-box="true" data-virtual-scroll="false"">
                            <option value="">Selecione</option>
                            <option class="text-muted" selected value="{!!  Helpers\Helpers::getUserCompanyName(Auth::user()->id_cliente) !!}">{!! strtoupper(Helpers\Helpers::getUserCompanyName(Auth::user()->id_cliente)) !!}</option>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label for="localidade" class="form-label d-none d-lg-block">Localidade</label>
                        <select  class="form-control select2" id="localidade" name="localidade"data-hide-disabled="true" data-actions-box="true" data-virtual-scroll="false">
                            @if(!empty($localidades))
                                @if(gettype($localidades) == 'array' )
                                    <option value="">Selecione</option>
                                    @for($i=0; $i< sizeof(@$localidades); $i++)
                                        <option class="text-muted">{!! @$localidades[$i]->nome_localidade !!}</option>
                                    @endfor
                                @else 
                                    <option class="text-muted" selcted>{!! @$localidades !!}</option>
                                @endif
                            @endif
                        </select>
                    </div>        
                    <div class="col" >
                        <button type="submit" class="btn btn-primary float-end">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-search" viewBox="0 0 16 16">
                                    <path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001q.044.06.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1 1 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0"></path>
                                </svg>
                                Buscar
                            </button>
                        </div>
                    </form>
                        </div>
                </div>
                <!--search -->
                <div class="container-xxl mt-4 mobile ">
                    <div class="row gx-2">
                        <table class="table_list">
                            @for($i=0; $i<sizeof($inventario); $i++)
                                <tr class="card my-2" onclick="getDetails('{!! $inventario[$i]->id_localidade !!}')">
                                    <td class="w-90 d-flex justify-content-between card-header py-2">
                                        <div>
                                            <div class="text-secondary">Cliente</div>
                                            <abbr  class="initialism" style="font-size: 12px ">{!! strtoupper($inventario[$i]->nome_cliente) !!}</abbr>
                                        </div>
                                        <div style="width: 43%">
                                            <div class="text-secondary">Localidade</div>
                                            <abbr  class="initialism" style="text-align: left !important;font-size: 12px">{!! $inventario[$i]->nome_localidade!!}</abbr>
                                        </div>
                                        <div style="float: right !important">
                                            <div class="text-secondary">Quantidade</div>
                                            <abbr  class="initialism" style="float: right !important; margin-right:20%">{!! $inventario[$i]->quantidade!!}</abbr>
                                        </div>

                                    </td>
                                </tr>

                            @endfor
                        </table>
                    </div>
                </div>
                <div class="container-xxl mt-4 mobile ">
                    <div class="row">
                        <div  class='col-lg-5'>
                            @if($inventario instanceof \Illuminate\Pagination\AbstractPaginator)
                                {{$inventario->withQueryString()->links()}}
                            @endif
                        </div>
                    </div>
                </div>
            <!--mobile-->

        @else
        <div class="row gx-5 gy-3 mt-3 ">
            <form method="POST" action="{!! route('busca_invetario') !!}" class="row g-3">
                @csrf
                <div class="col-md-6">
                    <label for="cliente" class="form-label d-none d-lg-block">Cliente</label>
                    <select  class="form-control select2" id="cliente" name="cliente" data-hide-disabled="true" data-actions-box="true" data-virtual-scroll="false">
                        <option value="">Selecione</option>
                        <option class="text-muted" selected value="{!!  Helpers\Helpers::getUserCompanyName(Auth::user()->id_cliente) !!}">{!! strtoupper(Helpers\Helpers::getUserCompanyName(Auth::user()->id_cliente)) !!}</option>
                    </select>
                </div>
                <div class="col-md-6">
                    <label for="localidade" class="form-label d-none d-lg-block">Localidade</label>
                    <select  class="form-control select2" id="localidade" name="localidade"data-hide-disabled="true" data-actions-box="true" data-virtual-scroll="false">
                        @if(!empty($localidades))
                            @if(gettype($localidades) == 'array' )
                                <option value="">Selecione</option>
                                @for($i=0; $i< sizeof(@$localidades); $i++)
                                    <option class="text-muted">{!! @$localidades[$i]->nome_localidade !!}</option>
                                @endfor
                            @else 
                                <option class="text-muted" selcted>{!! @$localidades !!}</option>
                            @endif
                        @endif
                    </select>
                </div>
                <div class="col" >
                    <button type="submit" class="btn btn-primary float-end">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-search" viewBox="0 0 16 16">
                            <path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001q.044.06.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1 1 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0"></path>
                        </svg>
                        Buscar
                    </button>
                </div>
            </form>
        </div>
    </div>
    <!--table-->
    <!--end table-->
    <div class="container-xxl mt-4 mobile ">
        <div class="row">
            <table class="table_list">
            @for($i=0; $i<sizeof($inventario); $i++)
                <tr class="card my-2" onclick="getDetails('{!! $inventario[$i]->id_localidade !!}')">
                    <td class="w-100 d-flex justify-content-between card-header py-4">
                        <div>
                            <div class="text-secondary">Cliente</div>
                            <abbr  class="initialism">{!! strtoupper($inventario[$i]->nome_cliente) !!}</abbr>
                        </div>
                        <div class="float-child" style="align-items: start !important">
                            <div class="text-secondary">Localidade</div>
                            <abbr  class="initialism" style="text-align: left !important">{!! $inventario[$i]->nome_localidade!!}</abbr>
                        </div>
                        <div style="float: right !important">
                            <div class="text-secondary">Quantidade</div>
                            <abbr  class="initialism" style="float: right !important; margin-right:20%">{!! $inventario[$i]->quantidade!!}</abbr>
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
        @if($inventario instanceof \Illuminate\Pagination\AbstractPaginator)
            {{$inventario->withQueryString()->links()}}
        @endif
    </div>
        </div>
    </div>
    @endif
    <!--wrapper-->
</div>
</body>
<script  src="{{asset('/js/script.js')}}"></script>
<script  src="{{asset('/js/main.js')}}"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js"
        integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy"
        crossorigin="anonymous"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js"></script>

<script>



    function  getDetails(id_localidade)
    {
        URL = "{!! route('inventario_details') !!}"+"?id_localidade="+btoa(id_localidade)+"&_token={!! @csrf_token() !!}";
        window.location.href=URL;
    }


</script>
<script>
    $('.select2').select2();

</script>
</html>
