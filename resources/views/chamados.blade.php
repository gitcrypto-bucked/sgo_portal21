@php( App\Policies\PagePolicy::userCan(Route::currentRouteName()))

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
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.14.1/themes/base/jquery-ui.css">
    <link rel="stylesheet" href="{{asset('/css/sweetalert.css')}}">
    <link href="https://cdn.jsdelivr.net/gh/kartik-v/bootstrap-star-rating@4.1.2/css/star-rating.min.css" media="all" rel="stylesheet" type="text/css" />
    <link href="https://cdn.jsdelivr.net/gh/kartik-v/bootstrap-star-rating@4.1.2/themes/krajee-svg/theme.css" media="all" rel="stylesheet" type="text/css" />
    
	<!-- important mandatory libraries -->
	<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
	<script src="https://cdn.jsdelivr.net/gh/kartik-v/bootstrap-star-rating@4.1.2/js/star-rating.min.js" type="text/javascript"></script>

	<!-- with v4.1.0 Krajee SVG theme is used as default (and must be loaded as below) - include any of the other theme JS files as mentioned below (and change the theme property of the plugin) -->
	<script src="https://cdn.jsdelivr.net/gh/kartik-v/bootstrap-star-rating@4.1.2/themes/krajee-svg/theme.js"></script>


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
    <div class="container-xxl mt-4  ">
        <h2 class="content-title pageName" style="color: {!! \Helpers\Helpers::getTextClienteColor(Auth::user()->id_cliente)!!} !important">Gestão de Chamados</h2>
        <p class="pageText"></p>
        <!---content -->
        @if($agent->isMobile()!=false)
            <!--mobile -->
            <div class="row gx-5 gy-3 mt-3 ">
                <div class=" container mt-2 mb-3 " >
                    <div class="row px-4">
                        <table class="table" style=" --bs-table-border-color: #4a5568 !important; outline: none; border: none !important;">
                            <tr >
                                <td colspan="2" >
                                    <p class="initialism_alt float-start">Chamados Abertos:&nbsp;0 </p>
                                </td>
                                <td colspan="2">
                                    <p class="initialism_alt ">Chamados Fechados:&nbsp;0 </p>
                                </td>
                                <td colspan="2">
                                    <p class="initialism_alt float-send">Chamados Cancelados:&nbsp;0 </p>
                                </td>
                            </tr>
                        </table>
                    </div>
                </div>
                <!---search -->
                <div class=" container-xxl mt-2 " >
                    <div class="row gx-5 gy-3 mt-3 ">
                        <div class="col" >
                            <button class="btn float-end " type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasRight" aria-controls="offcanvasRight"><i class="fa fa-bars" aria-hidden="true"></i>
                            </button>

                            <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasRight" aria-labelledby="offcanvasRightLabel" style="background-color: var(--body-color) !important;">
                                <div class="offcanvas-header">

                                    <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
                                </div>
                                <div class="offcanvas-body" style="background-color: var(--body-color) !important;">
                                    <div class="row gx-5 gy-3  ">
                                        <div class="col-md-6 ">
                                            <div class="mb-1">
                                                <label for="exampleInputEmail1" class="form-label">Buscar:</label>
                                                <div class="input-group mb-3">
                                                    <input type="text" class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-default">
                                                    <span class="input-group-text bg-transparent" id="inputGroup-sizing-default"><i class="fa fa-search" aria-hidden="true"></i></span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-3 ">
                                            <div class="mb-1">
                                                <label for="exampleInputEmail1" class="form-label">Data Inicial:</label>
                                                <div class="input-group mb-3">
                                                    <label class="input-group-text" for="inputGroupSelect01"><i class="fa fa-calendar" aria-hidden="true"></i></label>
                                                    <input type="text" id="inputGroupSelect01" class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-default">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="mb-1">
                                                <label for="exampleInputEmail1" class="form-label">Data Final:</label>
                                                <div class="input-group mb-3">
                                                    <label class="input-group-text" for="inputGroupSelect02"><i class="fa fa-calendar" aria-hidden="true"></i></label>
                                                    <input type="text" id="inputGroupSelect02" class="form-control">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg">
                                            <div class="mb-1">
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="radio" name="inlineRadioOptions" id="inlineRadio1" value="todos">
                                                    <label class="form-check-label" for="inlineRadio1">Todos</label>
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="radio" name="inlineRadioOptions" id="inlineRadio2" value="em anadamento">
                                                    <label class="form-check-label" for="inlineRadio2">Em andamento</label>
                                                </div>

                                            </div>
                                        </div>
                                        <div class="col-lg">
                                            <div class="mb-1">
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="radio" name="inlineRadioOptions" id="inlineRadio2" value="fechado">
                                                    <label class="form-check-label" for="inlineRadio2">Fechado</label>
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="radio" name="inlineRadioOptions" id="inlineRadio2" value="cancelado">
                                                    <label class="form-check-label" for="inlineRadio2">Cancelado</label>
                                                </div>
                                            </div>
                                        </div>
                                        <br>
                                        <div class="col" >
                                            <button type="submit" class="btn btn-success float-end"  data-bs-dismiss="offcanvas">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-search" viewBox="0 0 16 16">
                                                    <path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001q.044.06.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1 1 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0"></path>
                                                </svg>
                                                Buscar
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <a type="button" class="btn btn-success float-end px-4 @if(isset(Auth::user()->abrir_chamado) && boolval(Auth::user()->abrir_chamado)) d-none @else d-none @endif " href="{{route('abrir_chamado')}}" ><i class="fa fa-plus" aria-hidden="true"></i>&nbsp;Abrir</a>
                        </div>
                    </div>
                </div>
                <!---search -->
                <div class=" container-xxl  mt-2 " >
                    <div class="row px-4">
                                <table class="table_list px-2">
                                    @for($i=0; $i<sizeof($chamados); $i++)
                                        <tr class="card my-2">
                                            <td class="card-header d-flex justify-content-between">
                                                <div class="float-child_invoice_chamados_first">
                                                    <div class="text-secondary">N° Chamado</div>
                                                    <div class="green"><abbr title="HyperText Markup Language" class="initialism_alt">{!! strtoupper($chamados[$i]->numero_chamado_interno) !!}</abbr></div>
                                                </div>


                                                <div class=" ">
                                                    <div class="text-secondary">Serial</div>
                                                    <div class="green"><abbr title="HyperText Markup Language" class="initialism">{!! strval($chamados[$i]->numero_serial) !!}</abbr></div>
                                                </div>

                                                <div >
                                                    <div class="text-secondary">Status</div>
                                                    <div class="green"><abbr title="HyperText Markup Language" class="initialism" style="text-transform: none; color:green">{!! "Fechado" !!}</abbr></div>
                                                </div>



                                                <div class=" px-2"  onclick="getDetails('{!!$chamados[$i]->numero_chamado_interno!!}','{!!$chamados[$i]->numero_serial!!}')">
                                                    <div class="text-secondary">&nbsp;</div>
                                                    <div class="green"><abbr title="HyperText Markup Language" class="initialism"><i class="fa-lg fa fa-eye" aria-hidden="true"></i></abbr></div>
                                                </div>

                                            </td>
                                        </tr>

                                    @endfor
                                </table>
                            </div>
                    </div>
                <!--paginator -->
                <div class="col-md-2">
                @if($chamados instanceof \Illuminate\Pagination\AbstractPaginator)
                    {{$chamados->withQueryString()->links()}}
                @endif
                </div>
                <!--div do container -->
            </div>
            <!--mobile -->
        @else
        @endif
        <!---web-->
        <div class="row gx-5 gy-3 mt-3 d-none">
            <div class=" container-xxl mt-2 " style="padding-right:  0px !important; padding-left: 0px!important">
                <div class="row px-4">
                    <table class="table" style="    --bs-table-border-color: #4a5568 !important; ">
                        <tr >
                            <td colspan="2" >
                                <p class="initialism_alt float-start">Chamados Abertos:&nbsp; </p>
                            </td>
                            <td colspan="2">
                                <p class="initialism_alt ">Chamados Fechados:&nbsp; {!! $fechados !!}</p>
                            </td>
                            <td colspan="2">
                                <p class="initialism_alt float-send">Chamados Cancelados:&nbsp;0 </p>
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
            <br>
            <div class="row gx-5 gy-3 mt-3 d-none">
                <div class="col">
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="inlineRadioOptions" id="inlineRadio1" value="todos">
                        <label class="form-check-label" for="inlineRadio1">Todos</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="inlineRadioOptions" id="ongoing" value="ongoing">
                        <label class="form-check-label" for="inlineRadio2">Em Andamento</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="inlineRadioOptions" id="fechado" value="fechado" >
                        <label class="form-check-label" for="fechado">Fechado</label>
                    </div>

                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="inlineRadioOptions" id="cancelado" value="cancelado" >
                        <label class="form-check-label" for="cancelado">Cancelado</label>
                    </div>
                </div>
                <div class="col  @if(isset(Auth::user()->abrir_chamado) && boolval(Auth::user()->abrir_chamado)) d-none @else d-none @endif ">
                    <a type="button" class="btn btn-success float-end px-4" href="{{route('abrir_chamado')}}" ><i class="fa fa-plus" aria-hidden="true"></i>&nbsp;Abrir</a>
                </div>
            </div>
            <!--table-->
            <div class="row gx-5 gy-3 mt-3 d-none">
                <div class="col-md-6 ">
                    <div class="mb-3">
                        <label for="exampleInputEmail1" class="form-label">Buscar:</label>
                        <div class="input-group mb-3">
                            <input type="text" class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-default">
                            <span class="input-group-text bg-transparent" id="inputGroup-sizing-default"><i class="fa fa-search" aria-hidden="true"></i></span>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 ">
                    <div class="mb-3">
                        <label for="exampleInputEmail1" class="form-label">Data Inicial:</label>
                        <div class="input-group mb-3">
                            <label class="input-group-text" for="inputGroupSelect01"><i class="fa fa-calendar" aria-hidden="true"></i></label>
                            <input type="text" id="inputGroupSelect01" class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-default">
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="mb-3">
                        <label for="exampleInputEmail1" class="form-label">Data Final:</label>
                        <div class="input-group mb-3">
                            <label class="input-group-text" for="inputGroupSelect02"><i class="fa fa-calendar" aria-hidden="true"></i></label>
                            <input type="text" id="inputGroupSelect02" class="form-control">

                        </div>
                    </div>
                </div>
                <div class="col" >
                    <button type="button" class="btn btn-primary float-end">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-search" viewBox="0 0 16 16">
                            <path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001q.044.06.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1 1 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0"></path>
                        </svg>
                        Buscar
                    </button>
                </div>
            </div>
        </div>
        <!--table-->
            <!--end table-->
            <div class="container-xxl mt-4 mobile mt-4 ">
                <div class="row">
                    <table class="table_list">
                        @for($i=0; $i<sizeof($chamados); $i++)
                            <tr class="card my-2">
                                <td class="card-header" style="height: 88px !important">
                                    <div class="float-container">
                                        <div class="float-child_invoice_chamados_first">
                                            <div class="text-secondary">N° Chamado</div>
                                            <div class="green"><abbr title="HyperText Markup Language" class="initialism_alt">{!! strtoupper($chamados[$i]->numero_chamado_interno) !!}</abbr></div>
                                        </div>

                                        <div class="float-child_invoice_chamados d-none  d-md-block d-lg-block">
                                            <div class="text-secondary">Aberto por</div>
                                            <div class="green"><abbr title="HyperText Markup Language" class="initialism">{!! ucwords($chamados[$i]->users_name) !!}</abbr></div>
                                        </div>

                                        <div class="float-child_invoice_chamados ">
                                            <div class="text-secondary">Serial</div>
                                            <div class="green"><abbr title="HyperText Markup Language" class="initialism">{!! strval($chamados[$i]->numero_serial) !!}</abbr></div>
                                        </div>
                                        <div class="float-child_invoice_chamados">
                                            <div class="text-secondary">Status</div>
                                            <div class="green"><abbr title="HyperText Markup Language" class="initialism">@if($chamados[$i]->data_fechamento==='' ||$chamados[$i]->data_fechamento===null) {!!  'Aberto' !!} @else {!! 'Fechado' !!} @endif</abbr></div>
                                        </div>

                                        <div class="float-child_invoice_chamados d-none  d-md-block d-lg-block">
                                            <div class="text-secondary">Data Abertura</div>
                                            <div class="green"><abbr title="HyperText Markup Language" class="initialism">{!! date('d/m/Y', strtotime(str_replace('-','/',$chamados[$i]->data_criacao))) !!}</abbr></div>
                                        </div>

                                        <div class="float-child_invoice_chamados d-none  d-md-block d-lg-block">
                                            <div class="text-secondary">Data da Solução</div>
                                            <div class="green"><abbr title="HyperText Markup Language" class="initialism">{!! strlen($chamados[$i]->data_fechamento) ? date('d/m/Y', strtotime(str_replace('-','/',$chamados[$i]->data_fechamento))): '---' !!}</abbr></div>
                                        </div>
                                        <div class="float-child_invoice_rating d-none d-md-block d-lg-block">
                                            <div class="text-secondary">Avaliação</div>
                                        
                                                <input id="input-7-sm" name="input-7-sm"
                                                            value="{!! intval($chamados[$i]->avaliacao) !!}"  
                                                            onchange="processRating(this)"
                                                            data-id="{!! intval($chamados[$i]->uid) !!}"
                                                            data-show-caption="false"
                                                            data-show-clear="false"  data-size="sm"
                                                            class="rating " data-min="0" data-max="5" data-step="1" 
                                                            >
                                        </div>
                                        <div class="float-child_invoice_eye"  onclick="getDetails('{!!$chamados[$i]->numero_chamado_interno!!}','{!!$chamados[$i]->numero_serial!!}')">
                                            <div class="text-secondary">&nbsp;</div>
                                            <div class="green"><abbr title="HyperText Markup Language" class="initialism"><i class="fa-lg fa fa-eye" aria-hidden="true"></i></abbr></div>
                                        </div>
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
                        @if($chamados instanceof \Illuminate\Pagination\AbstractPaginator)
                            {{$chamados->withQueryString()->links()}}
                        @endif
                    </div>
                </div>
            </div>

        </div>
        <!--web-->
    </div>
        <!---content -->
    </div>
</div>
</body>
<script  src="{{asset('/js/script.js')}}"></script>
<script  src="{{asset('/js/main.js')}}"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js"
        integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy"
        crossorigin="anonymous"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<script src="https://code.jquery.com/ui/1.14.1/jquery-ui.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.i18n/1.0.9/jquery.i18n.js"
        integrity="sha512-OU7TUd3qODSbwnF5mHouW66/Yt54mzh58k+rxfJili7AunMl5wbF2D8kLGTGuUv5xM2MfylWZOPZaqOKpf7dZg==" 
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script>
    $.datepicker.setDefaults( $.datepicker.regional[ "pt-BR" ] );

    $( "#inputGroupSelect01" ).datepicker();
    $( "#inputGroupSelect02" ).datepicker();



    function  getDetails(e,a)
    {

        let url ="{!! route('chamados_details') !!}"+'?numero_chamado='+btoa(e)+'&serial='+btoa(a)+"&_token={!! @csrf_token() !!}";
        window.location.href=url;
    }


    $(document).ready(function() {
        $('.star-icon').each(function() 
        {
            $(this).hover(function() 
            {
                $(this).prevAll().addBack().css("color", "#FFDF00");
            }, 
            function() 
            {
                if (!$(this).parent().attr("data-rating")) 
                {
                    $(this).prevAll().addBack().css("color", "lightgrey");
                } 
                else 
                {
                    $(this).siblings().addBack().each(function(index) 
                    {
                        index + 1 <= $(this).parent().attr("data-rating") ?
                            $(this).css("color", "#FFDF00") : $(this).css("color", "lightgrey");
                    });
                }
            })
            .click(function () 
            {
                $(this).parent().attr("data-rating", $(this).prevAll().length + 1);
            });
        });
    });


    function processRating(elem)
    {
        console.log(elem.value, elem.dataset.id);
        let id = elem.dataset.id;
        let rating = elem.value;
        setRating(id,rating);
    }

    async function setRating(uid, rating)
    {
        let formData  = new FormData()
           formData.append('_token','{!! @csrf_token() !!}');
           formData.append('csrf','{!! @csrf_token() !!}');
           formData.append('uid',uid);
           formData.append('rating',rating);

           const response = await fetch(
               '{{route('chamados-rating')}}',
               {
                   method: 'POST',
                   headers: {
                       'x-rapidapi-host': 'carbonfootprint1.p.rapidapi.com',
                       'x-rapidapi-key': 'your_api_key'
                   },
                   body: formData
               }
           );
        const res = await response.text();
        if(res)
        {
            console.log(res);

        }
    }   


</script>
</html>
