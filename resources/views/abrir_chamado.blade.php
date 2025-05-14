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
    <meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate" />
    <meta http-equiv="Pragma" content="no-cache" />
    <meta http-equiv="Expires" content="0" />
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Portal LowCost</title>
    <!--  <link rel='stylesheet' href='https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css'>-->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
          integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH"
          crossorigin="anonymous">
    <link rel='stylesheet' href='https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css'>
    <link rel="stylesheet" href="{{asset('/css/style.css')}}">
    <link rel="stylesheet" href="{{asset('/css/dropdown.css')}}">
    <link rel="stylesheet" href="{{asset('/css/news.css')}}">
    <link rel="stylesheet" href="{{asset('/css/placeholder.css')}}">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

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

    <!--navbar -->
    <!--content-->
    <div class="container-xxl px-4 mt-4 mobile">
        <h2 class="content-title pageName" style="color: {!! \Helpers\Helpers::getTextClienteColor(Auth::user()->id_cliente)!!} !important">Abir Chamado</h2>

        @if($agent->isMobile()!=false)
            <div class="col-md-4">

                <form id="registerForm" method="POST"  autocomplete="off" action="{{url('/novo_chamado')}}" class="form-floating" enctype="multipart/form-data">

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
                        <select class="form-select" id="level" name="level"  required>
                            <option  value="0">Alta</option>
                            <option  value="1">Média</option>
                            <option  selected value="2">Baixa</option>
                        </select>
                        <label for="level">Selecione a prioridade </label>
                    </div>
                    <div class="form-floating mb-3">
                        <input type="text" class="form-control" id="titulo" name="titulo" required >
                        <label for="name">Titulo</label>
                    </div>


                   

                    <div class="form-floating mb-3">
                        <textarea  class="form-control" id="descricao" name="descricao"    rows="10" style="height: 160px"></textarea>
                        <label for="centrocusto">Descriçao</label>
                    </div>

                    <div class="form-floating mb-3">
                        <input class="form-control" type="file" id="formFile" name="formFile" accept="image/*">
                    </div>


                    <div class="mb-3 form-group">
                        <button type="submit" class="btn btn-primary mb-2"  >Cadastrar</button>
                        <button type="reset" class="btn btn-danger btn-lg-danger bg-danger mb-2" >Cancelar</button>
                    </div>
                </form>
            </div>


        @else
        <div class="row gx-2 gy-3 mt-3 ">
            <!-- News Block -->

            <div class="col-md-5">

                <form id="registerForm" method="POST"  autocomplete="off" action="{{url('/novo_chamado')}}" class="form-floating" enctype="multipart/form-data">

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
                    <div class="col mb-3">
                        <label for="equipamento" class="form-label d-none d-lg-block">Equipamento</label>
                            <select  class="form-control select2" id="equipamento" name="id_ativo_equipamento" 
                                                                  data-hide-disabled="true" 
                                                                  data-actions-box="true" 
                                                                  data-virtual-scroll="false">
                                @if(isset($inventario))
                                    @for($i=0; $i<sizeof($inventario); $i++)
                                        <option class="text-muted" id='{!! $inventario[$i]->id_equipamento !!}' value='{!! $inventario[$i]->id_ativo_equipamento !!}'>{!! $inventario[$i]->serial_equipamento !!} - {!! $inventario[$i]->modelo_equipamento !!}</option>
                                    @endfor
                                    @else
                                        <option class="text-muted" selected value='{!! $modelo[0]->id_ativo_equipamento !!}'>{!! $modelo[0]->serial_equipamento !!} - {!! ucwords($modelo[0]->modelo_equipamento) !!}</option>
                                    @endif
                            </select>
                       
                    </div>
                    <div class="form-floating mb-3 ">
                        <select class="form-select" id="level" name="level"  required>
                            <option  value="0">Alta</option>
                            <option  value="1">Média</option>
                            <option  selected value="2">Baixa</option>
                        </select>
                        <label for="level">Selecione a prioridade </label>
                    </div>
                    <div class="form-floating mb-3">
                        <input type="hidden" name='id_localidade' id='id_localidade' value="{!! $id_localidade !!}">
                        <input type="text" class="form-control" id="titulo" name="titulo" required >
                        <label for="name">Titulo</label>
                    </div>

                    <div class="form-floating mb-3">
                        <textarea  class="form-control" id="descricao" name="descricao"    rows="10" style="height: 160px"></textarea>
                        <label for="centrocusto">Descriçao</label>
                    </div>

                    <div class="form-floating mb-3">
                        <input class="form-control" type="file" id="formFile" name="files[]" 
                        accept=
                        "image/* , 
                        image/jpeg,
                        image/gif,
                         image/png,
                         application/pdf,
                         image/x-eps .csv,
                         application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, 
                         application/vnd.ms-excel" multiple
                          onchange="checkFiles(this.files)">
                    </div>
                    <div class="mb-3 form-group">
                        <button type="submit" class="btn btn-primary mb-2"  name='submit' >Cadastrar</button>
                        <button type="reset" class="btn btn-danger btn-lg-danger bg-danger mb-2" >Cancelar</button>
                    </div>
                    </form>
            </div>



            <!-- News block -->
        </div>
    </div>

    <!--content-->
   @endif

</div>
<!-- partial -->
<script  src="{{asset('/js/script.js')}}"></script>
<script  src="{{asset('/js/main.js')}}"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js"
        integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy"
        crossorigin="anonymous">
</script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js"></script>
<script>
    $('.select2').select2();
    
    function checkFiles(files)
    {       
        console.log(files); 
        if(files.length===3 || files.length<=3)
        {
            let list = new DataTransfer;
            for(let i=0; i<3; i++)
            {
                list.items.add(files[i]) 
            }
            document.getElementById('files').files = list.files
        }       
        else if(files.length>3) 
        {
            alert("Escolha somente 3 arquivos"); 
            document.getElementById('files').files = [];
            return;
        }    
    } 
    

</script>
</body>
</html>
