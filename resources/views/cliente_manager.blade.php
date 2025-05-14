
    <!DOCTYPE html>
<html lang="pt_BR" >
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="Ti team &amp; Low Cost contributors">
    <meta name="generator" content="Pedro Henrique & Deus">
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
    <link rel="stylesheet" href="{{asset('/css/search.css')}}">
    <link rel="stylesheet" href="{{asset('/css/list.css')}}">

    <link rel="stylesheet" href="{{asset('/css/sweetalert.css')}}">
    <script src="https://code.jquery.com/jquery-3.7.1.js"></script>
    <script src="https://cdn.datatables.net/2.1.8/js/dataTables.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>

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
    <div class="container-xxl mt-4  ">
        <h2 class="content-title pageName">Gerenciar clientes   </h2>
        <p class="pageText">Permite ativar e desativar clientes cadastrados.</p>
        @if(sizeof($clients)===1)
            <p class="pageText">Cliente: <p  class=" pageName" > {!! @ucfirst($clients[0]->cliente) !!}</p></p>
        @else
            <p class="pageText" > Cliente:  <p  class=" pageName" id="filterOutput"></p></p>
        @endif
        <div class="row gx-5 gy-3 mt-3 ">
            <!-- News Block -->
            <div class="col">
                    <form method="POST" action="{{route('filter-clientes')}}" enctype="multipart/form-data">
                        <div class=" form-group px-2 mb-4">
                            <div class="alert alert-success text-white bg-success" id="success" style="display:none">
                            </div>
                            <div class="alert alert-success text-white bg-success" id="erno" style="display:none">
                            </div>
                            @if(Session::has('error'))
                                <div class="alert alert-success bg-danger text-white" id="error">
                                    {{ Session::get('error')}}
                                </div>
                            @endif
                            @if (session('success') || Session::has('success'))
                                <div class="alert alert-success text-white bg-success" id="sucess">
                                    {{ session('success') || Session::get('success')}}
                                </div>
                            @endif
                            @csrf
                            <input type="text" id="myInput"  name="filter" onkeyup="myFunction()"  class="search" placeholder="Busca" @if(sizeof($clients)==1) value="{!! @ucfirst($clients[0]->cliente) !!}" @endif>
                            <div class="form-check mb-2 pb-2">
                                <input class="form-check-input" type="checkbox" id="flexCheckDefault" name="flexCheckDefault" value="1">
                                <label class="form-check-label text-dark" for="flexCheckDefault">
                                    Só ativos
                                </label>
                            </div>
                            <button type="submit" class="btn btn-primary reset" id="reset">Buscar&nbsp;<i class="fa fa-database"></i></button>
                            <button type="reset" class="btn btn-secondary reset" id="reset" onclick="window.location.href='{{route('cliente_manager')}}'">Limpar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        @if($agent->isMobile()!=false)
        <div class="container-xxl mt-4  ">
            <!-- form -->
            <!-- table button block -->
            <div class="row">
                    @dd($clients[0])
                    <table class="table_list px-2" id="myTable">
                        @for($i=0; $i<sizeof($clients); $i++)
                            <tr class="card px-2  vw-90 mb-3"  >

                                <td class="d-flex justify-content-between card-header py-4">
                                    <div class="d-none d-md-block ">
                                        <div class="text-secondary">#</div>
                                        <abbr  class="initialism">{!! $clients[$i]->id !!}</abbr>
                                    </div>
                                    <div>
                                        <div class="text-secondary">Cliente</div>
                                        <abbr  class="initialism" style="">{!! ucfirst(strtolower($clients[$i]->nome_cliente))!!}</abbr>
                                    </div>
                                    <div class="col-6 px-1 py-2">
                                        <div class="text-secondary px-2 py-2">ações</div>
                                        <button class="btn btn-outline-primary px-2 mb-1"  style="width: 38px" id="{{$clients[$i]->id_cliente}}" value="userlist" type="button" onclick="window.location.href='{{route('usuarios_clientes')}}?cliente={!! base64_encode($clients[$i]->nome_cliente) !!}&_token={!! @csrf_token() !!}'"  data-toggle="tooltip" data-placement="bottom" title="Usuarios">
                                            <i class="fa fa-user" aria-hidden="true"></i>
                                        </button>
                                        @if(@$clients[$i]->logo_cliente!='' || @$clients[$i]->logo_cliente!=NULL)
                                            <button class="btn btn-outline-primary px-2 mb-1" style="width: 38px!important;"  id="{{$clients[$i]->id_cliente}}"  value="{{asset('storage/public/'.$clients[$i]->path)}}"  aria="{{$clients[$i]->path}}"
                                                    type="button" onclick="update(this)" name="submitbutton"  data-toggle="tooltip" data-placement="bottom" title="Logo do Cliente">
                                                <i class="fa fa-picture-o" aria-hidden="true"></i>
                                            </button>
                                        @endif
                                        @if($clients[$i]->active =='1')
                                            <button  class="btn btn-outline-secondary px-2 mb-1" style="width: 38px" id="{{$clients[$i]->id_cliente}}" value="desativar" type="button" onclick="desativar(this)"  name="submitbutton"  data-toggle="tooltip" data-placement="bottom" title="Desativar">
                                                <i class="fa fa-times" ></i>
                                            </button>
                                        @else
                                            <button class="btn btn-outline-primary px-2 mb-1" style="width: 38px" id="{{$clients[$i]->id_cliente}}" value="ativar" type="button" onclick="ativar(this)" name="submitbutton" data-toggle="tooltip" data-placement="bottom" title="Ativar"><i class="fa fa-check"  ></i></button>
                                        @endif
                                        <button class="btn btn-outline-danger px-2 mb-1" style="width: 38px"  id="{{$clients[$i]->id_cliente}}" value="excluir" type="button" onclick="excluir(this)"   name="submitbutton" data-toggle="tooltip" data-placement="bottom" title="Excluir"><i class="fa fa-user-times"  ></i></button>

                                        @if(@ $clients[$i]->total>0)
                                            <button class="btn btn-outline-success px-2 " style="width: 38px" id="{{$clients[$i]->id_cliente}}" value="userlist" type="button" onclick="window.location.href='{{route('trocar_tela')}}?cliente={!! base64_encode($clients[$i]->nome_cliente) !!}&idCliente={!! base64_encode($clients[$i]->id_cliente    ) !!}}&_token={!! @csrf_token() !!}'"  data-toggle="tooltip" data-placement="bottom" title="Acesar cliente">
                                                <i class="fa fa-sign-in" aria-hidden="true"></i>
                                            </button
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @endfor
                    </table>
                <div  class='col-md-6 mt-4'>
                    @if($clients instanceof \Illuminate\Pagination\AbstractPaginator)
                        {{$clients->links()}}
                    @endif
                </div>
            </div>
        </div>
        @else
        <div class="container-xxl mt-4 mobile ">
            <!-- form -->
            <!-- table button block -->
                <table class="container" id="myTable">
                    @if(Session::has('error'))
                        <div class="alert alert-success bg-danger text-white" id="error">
                            {{ Session::get('error')}}
                        </div>
                    @endif
                    @for($i=0; $i<sizeof($clients); $i++)
                        <tr class="card my-2 mt-2">
                            <td class="w-90 d-flex justify-content-between card-header py-2">
                                <div>
                                    <div class="text-secondary">#</div>
                                    <abbr title="HyperText Markup Language" class="initialism">{!! $clients[$i]->id_cliente !!}</abbr>
                                </div>
                                <div style="width: 23%">
                                    <div class="text-secondary">Cliente</div>
                                    <abbr title="HyperText Markup Language" class="initialism">{!! $clients[$i]->nome_cliente !!}</abbr>
                                </div>
                                <div style="width: 23%">
                                    <div class="text-secondary">ações</div>
                                    @if($clients[$i]->active =='1')
                                        <button  class="btn btn-outline-secondary px-2" id="{{$clients[$i]->id_cliente}}" value="desativar" type="button" onclick="desativar(this)"  name="submitbutton" data-toggle="tooltip" data-placement="top" title="Desativar"><i class="fa fa-times"  ></i></button>
                                    @else
                                        <button class="btn btn-outline-primary px-2" id="{{$clients[$i]->id_cliente}}" value="ativar" type="button" onclick="ativar(this)" name="submitbutton" data-toggle="tooltip" data-placement="top" title="Ativar"><i class="fa fa-check"  ></i></button>
                                    @endif
                                    <button class="btn btn-outline-danger px-2"  id="{{$clients[$i]->id_cliente}}" value="excluir" type="button" onclick="excluir(this)"   name="submitbutton"  data-toggle="tooltip" data-placement="top" title="Excluir"><i class="fa fa-user-times" ></i></button>
                                        <button class="btn btn-outline-success" id="{{$clients[$i]->id_cliente}}" value="userlist" type="button" onclick="window.location.href='{{route('usuarios_clientes')}}?cliente={!! base64_encode($clients[$i]->id_cliente) !!}&_token={!! @csrf_token() !!}'">Ver Usuarios</button>
                                   
                                        <button class="btn btn-outline-success" id="{{$clients[$i]->nome_cliente}}" value="userlist" type="button" onclick="window.location.href='{{route('trocar_tela')}}?cliente={!! base64_encode($clients[$i]->nome_cliente) !!}&idCliente={!! base64_encode($clients[$i]->id_cliente    ) !!}}&_token={!! @csrf_token() !!}'" data-toggle="tooltip" data-placement="top" title="Acessar cliente">
                                            <i class="fa fa-sign-in" aria-hidden="true"></i>
                                        </button>
                                </div>
                                <div class="px-4" style="width: 13%">
                                    <div class="text-secondary">logo</div>
                                    @if($clients[$i]->logo_cliente!='' || $clients[$i]->logo_cliente!=NULL)
                                        <button class="btn btn-outline-info px-2"  id="{{$clients[$i]->id_cliente}}"  
                                            value="{{asset('clientes/'.$clients[$i]->logo_cliente)}}" 
                                             aria="{{$clients[$i]->path}}"
                                              data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Alterar logo"
                                                type="button" onclick="update(this)" name="submitbutton">
                                            <i class="fa fa-picture-o" aria-hidden="true"></i>
                                        </button>
                                    @elseif($clients[$i]->logo_cliente=='' || $clients[$i]->logo_cliente==NULL)   
                                        <button class="btn btn-outline-primary px-2"  id="{{$clients[$i]->id_cliente}}"  value="{{$clients[$i]->id_cliente}}"
                                                class="btn btn-secondary" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Cadastrar logo"
                                                type="button" onclick="addLogo(this)" name="submitbutton">
                                            <i class="fa fa-crop" aria-hidden="true"></i>
                                        </button>
                                    @endif
                                </div>  
                                <div class="px-1" style="width: 13%">  
                                    <div class="text-secondary">cor de destaque</div>
                                    <button class="btn btn-outline-primary px-2"  id="{{$clients[$i]->id_cliente}}"  value="{{$clients[$i]->id_cliente}}"
                                            class="btn btn-secondary" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Alterar cor de destaque"
                                            type="button" onclick="addColor(this)" name="submitbutton">
                                            <i class="fa fa-paint-brush" aria-hidden="true"></i>
                                    </button>
                                </div>
                            </td>       
                        </tr>    
                    @endfor
                </table>
            <!-- table button block -->
                    <div  class='col-lg-8 mt-4'>
                        @if($clients instanceof \Illuminate\Pagination\AbstractPaginator)
                            {{$clients->links()}}
                        @endif
                    </div>
                </div>
        </div>
       @endif

    </div>
<!-- modal  active user -->
<div class="modal" tabindex="-1" id="modal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Logo do Cliente</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p id='msg'></p>
                <input type="hidden" id="clienteID">
                <div style="width: 300px; outline: none; border: 0px !important;margin-left: 30% !important;">
                    <img class="card-img-left img-fluid " alt="" id="image" width="200" height="200" style="border: 0px !important;outline: none !important;
                         padding:10px !important">
                </div>
                <input type="file" id="img" name="img" accept="image/*">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary"  onclick="validate(this)">Ativar</button>
            </div>
        </div>
    </div>
</div>
<!-- end modal  active user -->
<!--modal update cliente image -->
<div class="modal" tabindex="-1" id="modalUpdate">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Atualizar Logo do Cliente</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p id='msg2'></p>
                <input type="hidden" id="clienteIDUpdate">
                <div style="width: 300px; outline: none; border: 0px !important; margin-left: 30% !important;">
                    <img class="card-img-left  " alt="" id="imgUpdate" width="200" height="auto" style="border: 0px !important;outline: none !important;
                             padding:10px !important">
                </div>
                <input type="file" id="logoCliente" name="logoCliente" accept="image/*">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary"  onclick="check(this)">Atualizar</button>
            </div>
        </div>
    </div>
</div>
<!--end modal cliente image -->
<!--modal update cliente color -->
<div class="modal" tabindex="-1" id="modalColor">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Atualizar Cor de destaque do Cliente</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p id='msg2'></p>
                <input type="hidden" id="clienteIDColorUpdate">
                <label for="sidebar">Cor de destaque sidebar</label><br>
                <input type="color"  style="width: 180px;border-radius:5px" id="sidebar" name="sidebar" value="#5885af">
                <label for="header">Cor de destaque Header (nome da pagina)</label><br>
                <input type="color"  style="width: 180px;border-radius:5px" id="header" name="header" value="#75e6da">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary"  onclick="colorUpdate(this)">Atualizar</button>
            </div>
        </div>
    </div>
</div>
<!--end modal cliente color -->
<!-- partial -->
<script  src="{{asset('/js/script.js')}}"></script>
<script  src="{{asset('/js/main.js')}}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/2.9.2/umd/popper.min.js" integrity="sha512-2rNj2KJ+D8s1ceNasTIex6z4HWyOnEYLVC3FigGOmyQCZc2eBXKgOxQmo3oKLHyfcj53uz4QMsRCWNbLd32Q1g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js"
        integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy"
        crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js" i
        ntegrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script type="text/javascript">
    $(function () {
        $("[rel='tooltip']").tooltip();
    });
</script>
<script type="text/javascript">

    function myFunction() {
        // Declare variables
        var input, filter, table, tr, td, i, txtValue;
        input = document.getElementById("myInput");
        filter = input.value.toUpperCase();
        table = document.getElementById("myTable");
        tr = table.getElementsByTagName("tr");

        // Loop through all table rows, and hide those who don't match the search query
        for (i = 0; i < tr.length; i++) {
            td = tr[i].getElementsByTagName("td")[0];
            if (td) {
                txtValue = td.textContent || td.innerText;
                if (txtValue.toUpperCase().indexOf(filter) > -1) {
                    tr[i].style.display = "";
                } else {
                    tr[i].style.display = "none";
                }
            }
        }
    }


    const img = document.getElementById('img');
    img.onchange = evt => {
        const [file] = img.files
        if (file) {
            document.getElementById('image').src = URL.createObjectURL(file)
        }
    }

    const logoCliente = document.getElementById('logoCliente');
    logoCliente.onchange = evt =>{
        const [file] = logoCliente.files
        if (file) {
            document.getElementById('imgUpdate').src = URL.createObjectURL(file)
        }
    }

    function validate(elem)
    {
        if( document.getElementById('img').value==''||  document.getElementById('img')==undefined )
        {
            document.getElementById('msg').innerHTML='Por favor envie o logo do cliente';
            return;
        }
        else
        {
            $("#modal").modal('hide')
            doActivate(document.getElementById('clienteID').value );
        }
    }

    function desativar(elem)
    {
        doDeactivate(elem.id)
    }

    function ativar(elem)
    {
        document.getElementById('clienteID').value = elem.id;
        $("#modal").modal('toggle');
    }

    function excluir(elem)
    {
        console.log(elem.id)
        Swal.fire({
            title: "O cliente selecionado será excluído, não será possivel aos usuarios deste cliente entrar no portal",
            showDenyButton: true,
            showCancelButton: false,
            confirmButtonText: "Excluir",
            denyButtonText: `Cancelar`
        }).then((result) => {
            /* Read more about isConfirmed, isDenied below */
            if (result.isConfirmed)
            {
                doRemove(elem.id);
            }
            else if (result.isDenied)
            {
                setTimeout(function (){
                    window.location.reload();
                },6500);
            }
        });
    }

    async function doRemove(id)
    {
        form = new FormData();
        form.append('id',id);
        form.append('_token','{!! @csrf_token() !!}');
        form.append('csrf','{!! @csrf_token() !!}');
        const response = await fetch(
            '{{route('remove-clientes')}}',
            {
                method: 'POST',
                headers: {
                    'x-rapidapi-host': 'carbonfootprint1.p.rapidapi.com',
                    'x-rapidapi-key': 'your_api_key'
                },
                body: form
            }
        );
        const res = await response.text();
        console.log(res)
        if(res)
        {
            resp = JSON.parse(res);
            console.log(resp);
            if(resp.status==202)
            {
                document.getElementById('success').style.display='block';
                document.getElementById('success').innerHTML='Cliente excluido com sucesso';
                setTimeout(function (){
                    document.getElementById('success').style.display='none';
                    location.reload();
                },6500);
            }
            else
            {
                document.getElementById('erno').style.display='block';
                document.getElementById('erno').innerHTML='Houve um erro ao excluir o cliente';
                setTimeout(function (){
                    document.getElementById('erno').style.display='none';
                    location.reload();
                },6500);
            }
        }
    }

    async function doActivate(id)
    {
        form = new FormData();
        form.append('id',id);
        form.append('_token','{!! @csrf_token() !!}');
        form.append('csrf','{!! @csrf_token() !!}');
        var input = document.querySelector('input[type="file"]');
        form.append('logo',input.files[0] );

        const response = await fetch(
            '{{route('active-clientes')}}',
            {
                method: 'POST',
                headers: {
                    'x-rapidapi-host': 'carbonfootprint1.p.rapidapi.com',
                    'x-rapidapi-key': 'your_api_key'
                },
                body: form
            }
        );
        const res = await response.text();
        if(res)
        {
            resp = JSON.parse(res);
            console.log(resp);

            if(resp.status==202)
            {
                document.getElementById('success').style.display='block';
                document.getElementById('success').innerHTML='Cliente ativado com sucesso';
                setTimeout(function (){
                    document.getElementById('success').style.display='none';
                    location.reload();
                },6500);
            }
            else
            {
                document.getElementById('erno').style.display='block';
                document.getElementById('erno').innerHTML='Houve um erro ao ativar o cliente';
                setTimeout(function (){
                    document.getElementById('erno').style.display='none';
                    location.reload();
                },6500);
            }
        }
    }

    async function doDeactivate(id)
    {
        form = new FormData();
        form.append('id',id);
        form.append('_token','{!! @csrf_token() !!}');
        form.append('csrf','{!! @csrf_token() !!}');
        const response = await fetch(
            '{{route('disable-clientes')}}',
            {
                method: 'POST',
                headers: {
                    'x-rapidapi-host': 'carbonfootprint1.p.rapidapi.com',
                    'x-rapidapi-key': 'your_api_key'
                },
                body: form
            }
        );
        const res = await response.text();
        console.log(res)
        if(res)
        {
            resp = JSON.parse(res);
            console.log(resp);
            if(resp.status==202)
            {
                document.getElementById('success').style.display='block';
                document.getElementById('success').innerHTML='Cliente desativado com sucesso';
                setTimeout(function (){
                    document.getElementById('success').style.display='none';
                    location.reload();
                },6500);
            }
            else
            {
                document.getElementById('erno').style.display='block';
                document.getElementById('erno').innerHTML='Houve um erro ao desativar o cliente';
                setTimeout(function (){
                    document.getElementById('erno').style.display='none';
                    location.reload();
                },6500);
            }
        }
    }

    function update(elem)
    {
        console.log(elem.value);
        //update cliente logo
        document.getElementById('clienteIDUpdate').value=elem.id;
        document.getElementById('imgUpdate').src=elem.value;
        $('#modalUpdate').modal('toggle');
    }

    function check(elem)
    {
        if(document.getElementById('logoCliente').value=="" || document.getElementById('logoCliente').value==undefined)
        {
            document.getElementById('msg2').innerHTML='Para atualizar o logo do cliente por favor selecione uma imagem.'
            return;
        }
        else
        {
            doUpdate(); return;
        }
    }

    async function doUpdate()
    {
        form = new FormData();
        form.append('idCliente',document.getElementById('clienteIDUpdate').value);
        form.append('_token','{!! @csrf_token() !!}');
        form.append('csrf','{!! @csrf_token() !!}');
        form.append('logo', document.getElementById('logoCliente').files[0]);

        const response = await fetch(
            '{{route('update-logo-clientes')}}',
            {
                method: 'POST',
                headers: {
                    'x-rapidapi-host': 'carbonfootprint1.p.rapidapi.com',
                    'x-rapidapi-key': 'your_api_key'
                },
                body: form
            }
        );
        const res = await response.text();
        if(res)
        {
            $('#modalUpdate').modal('hide');
            resp = JSON.parse(res);
            if(resp.status==202)
            {
                Swal.fire({
                    title: "Logo atualizado com sucesso!",
                    text: "",
                    icon: "success"
                });
            }
            else
            {
                document.getElementById('erno').style.display='block';
                document.getElementById('erno').innerHTML='Houve um erro ao ativar o cliente';
                setTimeout(function (){
                    document.getElementById('erno').style.display='none';
                    location.reload();
                },6500);
            }
        }
    }


    function addColor(elem)
    {
        document.getElementById('clienteIDColorUpdate').value=elem.id
        $('#modalColor').modal('toggle');
    }

    function colorUpdate()
    {
        let header = document.getElementById('header').value;
        let sidebar =  document.getElementById('sidebar').value;
        console.log(header,sidebar);
        if(sidebar!='#FFFFFF' && sidebar !='#000000' && header!='#FFFFFF')
        {
            var modal = new bootstrap.Modal(document.getElementById('modalColor'));
            modal.hide();
            doAddColor(sidebar, header);
        }
    }

    async function doAddColor(sidebar, header) 
    {
        form = new FormData();
        form.append('sidebar',sidebar);
        form.append('header',header);
        form.append('id_cliente',document.getElementById('clienteIDColorUpdate').value);
        form.append('_token','{!! @csrf_token() !!}');
        form.append('csrf','{!! @csrf_token() !!}');

        const response = await fetch(
            '{{route('cliente_color')}}',
            {
                method: 'POST',
                headers: {
                    'x-rapidapi-host': 'carbonfootprint1.p.rapidapi.com',
                    'x-rapidapi-key': 'your_api_key'
                },
                body: form
            }
        );
        const res = await response.text();
        console.log(res)
        if(res)
        {
            resp = JSON.parse(res);
            if(resp.status==202)
            {
                Swal.fire({
                    title: "Cores de destaque atualizadas com sucesso!",
                    text: "",
                    icon: "success"
                });
            }
        }
    }

</script>
</body>
</html>

