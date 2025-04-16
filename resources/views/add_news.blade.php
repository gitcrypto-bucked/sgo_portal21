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
    <link rel="stylesheet" href="{!! 'https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css' !!}"
          integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH"
          crossorigin="anonymous">
    <link rel='stylesheet' href='{!!'https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css'  !!}'>
    <link rel="stylesheet" href="{{asset('/css/style.css')}}">
    <link rel="stylesheet" href="{{asset('/css/dropdown.css')}}">
    <link rel="stylesheet" href="{{asset('/css/news.css')}}">
    <link rel="stylesheet" href="{{asset('/css/placeholder.css')}}">
</head>
<body>
<!-- partial:index.partial.html -->
<div id="wrapper">
    <!--sidebar-->
    @include('components.sidebar')

    <!--sidebar-->
    <!--navbar -->
    @include('components.navwrapper')

    <!--navbar -->
    <!--content-->
    <div class="container-xxl px-4 mt-4 mobile">
        <h2 class="content-title pageName">Cadastrar noticias</h2>
        <p class="pageText"></p>
        <div class="row mt-4 gx-3 ">
            <div class="col-md-4 gx-3 px-2">
                <form id="registerForm" method="POST" enctype="multipart/form-data" autocomplete="off" action="{{route('register_news')}}" class="form-floating">
                    @if(Session::has('error'))
                        <div class="alert alert-success bg-danger text-white" id="error">
                            {{ Session::get('error')}}
                        </div>
                    @endif
                    @if (session('success'))
                        <div class="alert alert-success text-white bg-success" id="sucess">
                            {{ session('success') }}
                        </div>
                    @endif
                    @csrf
                    <div class="form-floating mb-3">
                        <input type="text" class="form-control" id="title" name="title" required  minlength="8">
                        <label for="title">Titulo</label>
                    </div>
                    <div class="form-floating mb-3">
                        <textarea class="form-control"  id="sinopse"  name="sinopse" style="height: 100px" required minlength="20" maxlength="382"></textarea>
                        <label for="sinopse">Resumo</label>
                    </div>
                    <div class="form-floating mb-3">
                        <input type="text" class="form-control" id="webrul" name="webrul" required >
                        <label for="webrul">Url do artigo</label>
                    </div>
                    <div class="form-floating mb-3">
                        <input type="file" class="form-control" id="thumb" name="thumb" required accept="image/*" >
                        <label for="thumb">Foto</label>
                    </div>

                    <div class="mb-3 form-group">
                        <button type="submit" class="btn btn-primary mb-2"  >Cadastrar</button>
                        <button type="button" class="btn btn-danger btn-lg-danger bg-danger mb-2" onclick="limpaTela()" >Cancelar</button>
                    </div>
                </form>
            </div>
            <div class="col-md-7 px-2 mx-2">
                <small>Exibição como ficará</small>
                <div class="registration-right" style="padding-top: 0px !important;">

                    <div class="event-list">
                            <div class="card flex-row">
                                <img class="card-img-left img-fluid rounded" src="{{asset('/news/news_1.jpg')}}" alt="" id="image" style="width: 26% !important">
                                <div class="card-body">
                                    {{--                            <h4 class=""><small class="newsDate">AUG 01 2021</small> <p class="card-text">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed</p></h4>--}}
                                    <p class="mb-3 card-title border border-light" >
                                        <small class="newsDate">{{Date('d/m/y')}}&nbsp;</small><strong class="newsHeader text-break" id="newsHeader">Locação de equipamento...</strong>
                                    <p class="lh-0 newsText text-break" id="resumo">Em dúvida se a locação de equip..</p>
                                    </p>
                                    <p class=" link mt-1"  id="link" >...Continuar Lendo...</p>
                                </div>
                            </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
    <!--content-->


</div>
<!-- partial -->
<script  src="{{asset('/js/script.js')}}"></script>
<script  src="{{asset('/js/main.js')}}"></script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js"
        integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy"
        crossorigin="anonymous">

</script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/babel-polyfill/7.12.1/polyfill.min.js"
        integrity="sha512-uzOpZ74myvXTYZ+mXUsPhDF+/iL/n32GDxdryI2SJronkEyKC8FBFRLiBQ7l7U/PTYebDbgTtbqTa6/vGtU23A=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
<!-- v6 <script src="https://unpkg.com/babel-standalone@6/babel.min.js"></script> -->
<script src="https://unpkg.com/@babel/standalone/babel.min.js"></script>
<script type="text/javascript">

    //show labels into select for mobile



    function limpaTela()
    {
        document.getElementById('registerForm').reset();
        document.getElementById('newsHeader').innerHTML='Locação de equipamento...';
        document.getElementById('resumo').innerHTML='Em dúvida se a locação de equip...';
        document.getElementById('image').src = "{{'/thumb/news_1.jpg'}}";
    }
</script>
<script type="text/babel">
    const thumb = document.getElementById('thumb');
    thumb.onchange = evt => {
        const [file] = thumb.files
        if (file) {
            document.getElementById('image').src = URL.createObjectURL(file)
        }
    }

    let title = document.getElementById('title');
    let newsHeader = document.getElementById('newsHeader');
    title.onkeyup = function()
    {
        newsHeader.innerHTML = title.value;
    }


    let sinopse = document.getElementById('sinopse');
    let resumo = document.getElementById('resumo');
    sinopse.onkeyup = function()
    {
        resumo.innerHTML = sinopse.value;
    }


    let webrul = document.getElementById('webrul');
    let link = document.getElementById('link');
    webrul.onblur= function ()
    {
        link.onclick = function (){
            window.open(webrul.value,'_blank');
        }
    }

</script>


</body>
</html>
