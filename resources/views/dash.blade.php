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
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
          integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH"
          crossorigin="anonymous">
    <link rel='stylesheet' href='https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css'>
    <link rel="stylesheet" href="{{asset('/css/style.css')}}">
    <link rel="stylesheet" href="{{asset('/css/dropdown.css')}}">
    <link rel="stylesheet" href="{{asset('/css/dash.css')}}">
   
</head>
<body>
<!-- partial:index.partial.html -->
<div id="wrapper-alt">
   
    <!--navbar-->
    <div id="navbar-wrapper  " >
        <nav class="navbar navbar-expand-lg navbar-light bg-light">
            <div class="container-fluid">
                <a href="#" class="navbar-brand" id="sidebar-toggle"><i class="fa fa-bars"></i></a>

                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item d-sm-flex nav-logo">
                        <a class="nav-link d-sm-flex mt-2 " aria-current="page" ><img src="{{asset('/logo/logo.png')}}"  class="logo  d-sm-flex " width="137"></a>
                    </li>
                </ul>
                <form class="d-flex ml-4 d-none d-lg-flex">
                    @if(Auth::check())
                        <div class="dropdown  mx-2 px-2" id="newsIcon">
                            <button data-mdb-button-init
                                    data-mdb-ripple-init data-mdb-dropdown-init class="btn "
                                    type="button"
                                    id="dropdownMenuButton"
                                    data-mdb-toggle="dropdown"
                                    aria-expanded="false"
                                        >
                                <i class="fa fa-bell " aria-hidden="true" ></i>
                                </button>
                            <ul class="dropdown-menu dropdown-menu-center" aria-labelledby="dropdownMenuButton"  id="list">
                            </ul>
                        </div>
                    @endif
                    @if(Auth::check())
                        <a class="btn  btn text-dark fw-bolder fs-6 px-5" type="submit" href="{{url('/logout')}}">Sair</a>
                    @else
                        <a class="btn  btn text-dark fw-bolder fs-6 px-5" type="submit" href="{{url('/login')}}">Login</a>
                    @endif
                </form>
    </div>
    </nav>
    </div>
    <!--navbar end-->
    <!--sidebar-->
    <!--navbar -->
    @if($agent->isMobile()!=false)
        <div class="container-xl mt-4 mobile mb-2">
            <h2 class="content-title pageName welcome-text">Bem vindo, Usuário!</h2>
            <p class="text-normal mt-3 mb-3">Bem vindo ao portal Portal do Cliente LowCost.
                                    Aqui você pode ter controle completo dos equipamentos que sua empresa possui em locação, revisitar 
                                    locações antigas e renovar contratos e muito mais.
            </p>   
                <div class="row  gy-3 mt-3 mb-3  px-2 column-gap-2">                    
                        <!--faturamento -->   
                        <div class="col-md-5 gradient-custom ">
                            <div class="py-3 col" style="float:right;paddign-top:20px; text-align: right; position: relative;">
                                <h5>Faturamento</h5>
                                <p class="simpletext">Monitore o status dos <br> pagamentos realizados e <br>pendentes.</p>
                                <br><br>
                                <div  @if(boolval(Auth::user()->faturamento)==0)  data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Acesso não permitido" @endif>
                                    <button type="button" class="btn  btn-light card-btn @if(boolval(Auth::user()->faturamento)==0) disabled @endif" 
                                            onclick='window.location.href="{!! route("faturamento") !!}"'>Ver todos&nbsp;&nbsp;
                                            @if(boolval(Auth::user()->faturamento)==1)
                                                <i class="fa fa-chevron-right "> </i>
                                            @else
                                                <i class="fa fa-lock" aria-hidden="true"></i>
                                            @endif    
                                    </button>
                                </div>
                            </div>
                            <div class="my-0 py-0 ">
                                <img alt="" src="{{asset('img/calculator.png')}}" class="calculator-svg img-fluid">
                            </div>
                        </div>
                        <!--faturamento end-->
                        <!--chamados -->
                        <div class="col-md-5 gradient-custom ">
                            <div class="float-container">
                                <div class="float-child" style="width: 30% !important">
                                    <div class="my-0 py-0 " >
                                        <img alt="" src="{{asset('img/undraw_engineering_team_a7n2.svg')}}" class="undraw_engineering_team_a7n2 ">
                                    </div>
                                </div>
                                
                                <div class="float-child" style="width:70% !important">
                                    <div class=" py-3 px-3 col" style="float:right;paddign-top:20px;text-align: right; position:relative;">


                                        <h5>Chamados</h5>
                                        <p class="simpletext">Nos últimos 30 dias.</p>
                                                                          <!--- -->
                                        <ul>
                                            <li style="list-style-type: none !important;">
                                                <a class="simpletext text-white" style="padding-right: 30px;position:relative">Abertos</a>
                                                <a class="simpletext text-white">Concluídos</a>
                                            </li>
                                            <li style="list-style-type: none;">
                                                <a class="big-text  text-white" style="padding-right: 66px;position:relative">{!! $abertos !!}</a>
                                                <a class="big-text  text-white" style="padding-right: 12px;">{!! $fechados !!}</a>
                                            </li>
                                        </ul>
                                        <!--- -->
                                     
                                        <div  @if(boolval(Auth::user()->chamados)==0)  data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Acesso não permitido" @endif>
                                            <button type="button" 
                                                    onclick='window.location.href="{!! route("chamados") !!}"'
                                                    class="btn  btn-light card-btn @if(boolval(Auth::user()->chamados)==0) disabled @endif" >Ver todos&nbsp;&nbsp;
                                                    @if(boolval(Auth::user()->chamados)==1)
                                                        <i class="fa fa-chevron-right "> </i> 
                                                    @else 
                                                        <i class="fa fa-lock" aria-hidden="true"></i>
                                                    @endif
                                            </button>
                                        </div>
                                    </div>    
                                   
                                </div>
                                
                              </div>
                        </div>    
                </div>
               
        </div>    
    @else
    <!--content-->
        <div class="container-xxl mt-4 mobile mb-2">
            <h2 class="content-title pageName welcome-text">Bem vindo, Usuário!</h2>
            <p class="text-normal mt-3 mb-3">Bem vindo ao portal Portal do Cliente LowCost.
                                    Aqui você pode ter controle completo dos equipamentos que sua empresa possui em locação, revisitar 
                                    locações antigas e renovar contratos e muito mais.
            </p>

            <div class="row  gy-3 mt-3 column-gap-3">
                 <!--faturamento -->   
                <div class="col-6 gradient-custom ">
                    <div class="my-3 py-3 px-3 col" style="float:right;paddign-top:20px; text-align: right; position: relative;">
                        <h5>Faturamento</h5>
                        <p class="simpletext">Monitore o status dos <br> pagamentos realizados e <br>pendentes.</p>
                        <br><br>
                        <div  @if(intval(Auth::user()->faturamento)===0)  data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Acesso não permitido" @endif>
                            <button type="button" class="btn  btn-light card-btn @if(intval(Auth::user()->faturamento)===0) disabled @endif" 
                                    onclick='window.location.href="{!! route("faturamento") !!}"'>Ver todos&nbsp;&nbsp;
                                    @if(intval(Auth::user()->faturamento)===1)
                                        <i class="fa fa-chevron-right "> </i>
                                    @else
                                        <i class="fa fa-lock" aria-hidden="true"></i>
                                    @endif    
                            </button>
                        </div>
                    </div>
                    <div class="my-0 py-0 ">
                        <img alt="" src="{{asset('img/calculator.png')}}" class="calculator-png img-fluid">
                    </div>
                </div>
                <!--faturamento end-->
                <!--chamados -->
                <div class="col gradient-custom " >
                    <div class="my-3 py-3 px-3 col" style="float:right;paddign-top:20px;text-align: right; position:relative;">
                        <h5>Chamados</h5>
                        <p class="simpletext">Nos últimos 30 dias.</p>
                        <!--- -->
                        <ul>
                        <li style="list-style-type: none !important;">
                            <a class="simpletext text-white" style="padding-right: 30px;position:relative">Abertos</a>
                            <a class="simpletext text-white">Concluídos</a>
                        </li>
                        <li style="list-style-type: none;">
                            <a class="big-text  text-white" style="padding-right: 66px;position:relative">{!! $abertos !!}</a>
                            <a class="big-text  text-white" style="padding-right: 12px;">{!! $fechados !!}</a>
                        </li>
                        </ul>
                        <!--- -->
                        <div  @if(boolval(Auth::user()->chamados)==0)  data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Acesso não permitido" @endif>
                        <button type="button" 
                                onclick='window.location.href="{!! route("chamados") !!}"'
                                class="btn  btn-light card-btn @if(boolval(Auth::user()->chamados)==0) disabled @endif" >Ver todos&nbsp;&nbsp;
                                @if(boolval(Auth::user()->chamados)==1)
                                    <i class="fa fa-chevron-right "> </i> 
                                @else 
                                    <i class="fa fa-lock" aria-hidden="true"></i>
                                @endif
                        </button>
                    </div>
                    </div>
                    <div class="my-0 py-0 col">
                        <img alt="" src="{{asset('img/undraw_engineering_team_a7n2.png')}}" class="undraw_engineering_team_a7n2 img-fluid">
                    </div>
                </div>
                <!--chamados end-->
            </div>

        </div> 
        <div class="container-xxl mt-2 mobile mb-4">
            <div class="row  gy-3 mt-3 column-gap-3">

                <div class="col tracking">
                    <div class="grid-container " style="padding-right: 10px;margin-top:25px; ">
                        <div class="grid-child purple">
                        <img src="{{asset('img/Group_2.png')}}" class="tracking-png" alt="tracking">
                        </div>
                        <div class="grid-child green" style="text-align: right;">
                        <h5>Tracking</h5>
                        <p class="simpletext">Acompanhe a entrega <br> dos seus equipamentos.</p>
                        <div style="padding-top: 8vh;"  @if(boolval(Auth::user()->tracking)==0)  data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Acesso não permitido" @endif>
                            <button type="button" 
                                class="btn  btn-light card-btn @if(boolval(Auth::user()->tracking)==0) disabled @endif"   
                                onclick='window.location.href="{!! route("tracking") !!}"'>Ir&nbsp;&nbsp;
                                @if(boolval(Auth::user()->tracking)==1)
                                    <i class="fa fa-chevron-right "></i></button>
                                @else
                                    <i class="fa fa-lock" aria-hidden="true"></i>
                                @endif    
                        </div>
                        </div>
                    </div>
                </div>

                <div class="col inventario">
                    <div class="grid-container " style="padding-right: 10px;margin-top:25px; ">
                        <div class="grid-child purple">
                        <img src="{{asset('img/Group_25.png')}}" class="inventario-png" alt="inventario">
                        </div>
                        <div class="grid-child green" style="text-align: right;">
                        <h5>Inventário</h5>
                        <p class="simpletext">Um controle completo<br>de todos os seus <br>equipamentos e <br>serviços.</p>
                        <div style="padding-top: 3vh;" @if(boolval(Auth::user()->inventario)==0)  data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Acesso não permitido" @endif>
                            <button type="button"
                                onclick='window.location.href="{!! route("inventario") !!}"'    
                                class="btn  btn-light card-btn  @if(boolval(Auth::user()->inventario)==0) disabled @endif">Ir&nbsp;&nbsp;
                                @if(boolval(Auth::user()->inventario)==1)
                                    <i class="fa fa-chevron-right "></i> </button>
                                @else
                                    <i class="fa fa-lock" aria-hidden="true"></i>
                                @endif
                        </div>
                        </div>
                    </div>
                </div>

                <div class="col pesquisa disabled">
                    <div class="grid-container" style="padding-right: 10px;margin-top:25px; ">
                        <div class="grid-child purple" style="padding-top:15px">
                        <img src="{{asset('img/pesquisa.svg')}}" alt="pesquisa" class="pesquisa-png">
                        </div>
                        <div class="grid-child green" style="padding-left:12px">
                        <h5>Pesquisa de Satisfação</h5>
                        <p class="simpletext">Acesse os resultados<br>das pesquisas<br>realizadas.</p>
                        <div  class="botton-btn" id="botton-btn"   data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Novo módulo em breve">
                            <button type="button" class="btn  btn-light card-btn disabled" 
                                    >Ir&nbsp;&nbsp;
                                    @if(boolval(@Auth::user()->pesquisa)==1)
                                        <i class="fa fa-chevron-right "></i> </button>
                                    @else
                                        <i class="fa fa-lock" aria-hidden="true"></i>
                                    @endif
                            </button>
                        </div>
                        </div>
                    </div>
                </div>
            </div>    
        </div>    
        <footer class="container-xxl mt-3 mobile mb-4">
            <div class="row py-2">
                <div class="col-md-8 ">
                    <h5 class="mb-3">Últimas Notícias</h5>
                    @if(!empty($news))
                        @for($i=0; $i<sizeof($news); $i++    )
                            <figure class="d-flex">
                                <div class="flex-shrink-0">
                                    <img src="{{asset('news/news_1.jpg')}}" alt="" width="115" height="80" class="news-img">
                                    {{-- <img src="{{asset('storage/public/thumb_/'.$news[$i]->thumb)}}" alt="" width="110" height="80" class="news-img"> --}}
                                </div>
                                <div class="ms-3">
                                        <div class="text-nowrap " style="width: 6rem;">
                                            <date>{{date('d/m/Y',strtotime($news[$i]->created_at))}}&nbsp;</date><bold style="font-weight: 580">{{$news[$i]->title}}</bold>
                                        </div>
                                    <p class="smalltext">{{$news[$i]->intro}}&nbsp;<a class="link" href="{{$news[$i]->url}}" target="_blank">...Continuar lendo...</a></p>
                                </div>
                            </figure>
                        @endfor
                        @if($news instanceof \Illuminate\Pagination\AbstractPaginator)
                            {{$news->withQueryString()->links()}}
                        @endif
                    @endif
                </div>
            </div>    
            <button type="button" class="btn  btn-light " onclick="window.location.href='{!! route('list-news')!!}'"
                style="float:right; border:1px solid gray;border-radius:20px">Todas as notícias&nbsp;&nbsp;
                <i class="fa fa-chevron-right "> </i>
            </button>    
        </footer>        
    @endif
    <div class="mb-3 py-3"></div>
<script  src="{{asset('/js/script.js')}}"></script>
<script  src="{{asset('/js/main.js')}}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/2.9.2/umd/popper.min.js" integrity="sha512-2rNj2KJ+D8s1ceNasTIex6z4HWyOnEYLVC3FigGOmyQCZc2eBXKgOxQmo3oKLHyfcj53uz4QMsRCWNbLd32Q1g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js"
        integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy"
        crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"
            integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g=="
            crossorigin="anonymous"
            referrerpolicy="no-referrer">    
</script>
<script type='text/javascript'>
const tooltipTriggerList = document.querySelectorAll('[data-bs-toggle="tooltip"]')
const tooltipList = [...tooltipTriggerList].map(tooltipTriggerEl => new bootstrap.Tooltip(tooltipTriggerEl))
 </script>

<script>
    $( document ).ready(function() {
        getNotifications();
    });



    async function getNotifications()
    {
        const response = await fetch(
            '{{route('list-notifications')}}',
            {
                method: 'GET',
                headers: {
                    'x-rapidapi-host': 'carbonfootprint1.p.rapidapi.com',
                    'x-rapidapi-key': 'your_api_key'
                }
            }
        );
        const res = await response.text();
        if(res)
        {
            removeChild();
            addChild(res);
        }
    }


    function addChild(res)
    {
        resp = JSON.parse(res);

        const btn = document.getElementById('dropdownMenuButton');
        document.getElementById('newsIcon').style.display="block";

        const span = document.createElement('span');
                span.id='badge'
                span.innerHTML =  resp.data.length
                span.classList.add('badge');
                span.style.visibility="visible";
                btn.append(span);

        const list = document.getElementById('list');

        if(resp.data.length>0)
        {
            for(let i=0; i<resp.data.length; i++)
            {
                //console.log(resp.data[i]);
                //console.log(resp.data[i]['type']);


                if(resp.data[i]['type']==='news')
                {
                    list.innerHTML+='<li><a class="dropdown-item" href="{{ route('list-news') }}" value="'+resp.data[i]['show_till']+'"  >'+resp.data[i]['notification']+'</a></li>';
                }
                if(resp.data[i]['type']==='system' && resp.data[i]['user_email']=='{!! Auth::user()->email; !!}')
                {
                    list.innerHTML+='<li><a class="dropdown-item" value="'+resp.data[i]['show_till']+'"  >'+resp.data[i]['notification']+'</a></li>';
                }
            }
            setTimeout(checkNotification(resp.data),500);
        }
    }



    function removeChild()
    {
        const myNode = document.getElementById("list");
        while (myNode.lastElementChild)
        {
            myNode.removeChild(myNode.lastElementChild);
        }
    }


    setTimeout(function (){
        let badge = document.getElementById('badge');
        if(badge != undefined)
        {
            badge.style.visibility="hidden";
        }
    }, 7500);


    function checkNotification(notif)
    {
        for(let i=0; i<notif.length; i++)
        {
            let dateNow =  Date.parse(new Date())
            let dateTill = Date.parse(notif[i]['show_till']);
            console.log(dateNow, dateTill)
            if(dateNow >=dateTill)
            {
                hideNotifiction(notif[i]['id']);
            }

        }
    }

    async function hideNotifiction(id)
    {
        let formData  = new FormData()
        formData.append('_token','{!! @csrf_token() !!}');
        formData.append('csrf','{!! @csrf_token() !!}');
        formData.append('id',id);
        console.log(formData)
        const response = await fetch(
            '{{route('remove-notification')}}',
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
            resp = JSON.parse(res);
            console.log(resp);

        }
    }

    const MINUTES = 1000 * 60 * 2
    const intervalID = setInterval(function(){
        removeChild();
        getNotifications();
    }, MINUTES);
    // you can to stop the execution by calling clearInterval()
    clearInterval(intervalID);

</script>

</html>