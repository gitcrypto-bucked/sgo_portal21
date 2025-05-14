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
    <link rel="stylesheet" href="{{asset('/css/news.css')}}">
    <link rel="stylesheet" href="{{asset('/css/file_upload.css')}}">

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
    <div class="container-xxl mobile mt-2">
        <h2 class="content-title pageName mt-2 py-4" style="color: {!! \Helpers\Helpers::getTextClienteColor(Auth::user()->id_cliente)!!} !important">Carga de Dados - Faturamento</h2>
        <p class="pageText"></p>
        @if($agent->isMobile()!=false)
            <form method="POST" action="{{route('uploadInvoice')}}" enctype="multipart/form-data"  class="form_upload">
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
                    <div class="container  min-vh-100 mb-3">
                        <div class="d-grid gap-2"  style="margin-left: -12px">
                            <div class=" vw-100  px-4  text-center text-nowrap" >
                            <label for="images" class="drop-container" id="dropcontainer" onclick="document.getElementById('ffile').click()">
                                <i class="fa fa-file-excel-o" style="font-size: 55px;opacity: 0.8;"></i>
                                <span class="drop-title" style="font-size: 13px">Clique ou arraste para anexar um arquivo</span>
                                <input type="file" id="ffile" accept=" .csv" name="ffile"
                                       required >
                            </label>
                        </div>
                        <div class="col mt-3 mb-3">
                            <a class="link_download float-end mb-3 " href="{{asset('csv/faturamento.csv')}}" target="_blank">Faça o download do modelo</a>
                        </div>
                        <div class="col text-center mt-2" >
                            <button type="submit" class="btn buttom-upload mb-2 mt-2"  >Enviar</button>
                        </div>
                    </div>
                </div>
            </form>
        @else
            <form method="POST" action="{{route('uploadInvoice')}}" enctype="multipart/form-data"  class="form_upload">
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
                <div class="container-xxl mobile  min-vh-100 py-2">
                    <div class="d-grid gap-2">
                        <div class="col text-center text-nowrap" >
                            <label for="images" class="drop-container" id="dropcontainer" onclick="document.getElementById('ffile').click()">
                                <i class="fa fa-file-excel-o" style="font-size: 55px;opacity: 0.8;"></i>
                                <span class="drop-title">Clique ou arraste para anexar um arquivo</span>
                                <input type="file" id="ffile" accept=" .csv" name="ffile"
                                       required >
                            </label>
                        </div>
                        <div class="col">
                            <a class="link_download float-end " href="{{asset('csv/faturamento.csv')}}" target="_blank">Faça o download do modelo</a>
                        </div>
                        <div class="col text-center" >
                            <button type="submit" class="btn buttom-upload mb-2"  >Enviar</button>
                        </div>
                    </div>
                </div>
            </form>
        @endif
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
<script>
    const dropContainer = document.getElementById("dropcontainer")
    const fileInput = document.getElementById("ffile")


    dropContainer.addEventListener("dragover", (e) => {
        // prevent default to allow drop
        e.preventDefault()
    }, false)

    dropContainer.addEventListener("dragenter", () => {
        dropContainer.classList.add("drag-active")
    })

    dropContainer.addEventListener("dragleave", () => {
        dropContainer.classList.remove("drag-active")
    })

    dropContainer.addEventListener("drop", (e) => {
        e.preventDefault()
        dropContainer.classList.remove("drag-active")
        fileInput.files = e.dataTransfer.files
    })
</script>
</body>
</html>
