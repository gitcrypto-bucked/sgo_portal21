
@if(!isset($_GET['_token']))
    @php(redirect()->to('/cliente_manager'))
@endif
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
    <div class="container-xxl mt-4 mobile ">
        <h2 class="content-title pageName">Gerenciar Usuarios do Cliente   </h2>
        <p class="pageText">Permite ativar e desativar usuarios cadastrados.</p>
        <p  class=" pageName" >  Cliente: {!!ucwords(\Helpers\Helpers::getUserCompanyName($cliente)) !!}</p>

        <div class="row gx-5 gy-3 mt-3 ">
            <!-- News Block -->
            <div class="col">
                <form method="POST" action="{{route('filter-users')}}" enctype="multipart/form-data" >
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
                        <input type="hidden" value="{{$cliente}}" id="cliente" name="cliente">
                        <input type="text" id="myInput"  name="filter" onkeyup="myFunction()"  class="search" placeholder="Busca" @if(sizeof($users)==1)value="{!! $users[0]->name  !!}" @endif>
                        <div class="form-check mb-2 pb-2">
                            <input class="form-check-input" type="checkbox" id="flexCheckDefault" name="flexCheckDefault" value="1">
                            <label class="form-check-label text-dark" for="flexCheckDefault">
                                Só ativos
                            </label>
                        </div>
                        <button type="submit" class="btn btn-primary reset" id="reset">Buscar&nbsp;<i class="fa fa-database"></i></button>
                        <button type="reset" class="btn btn-secondary reset" id="reset"  onclick="window.location.href='{{route('usuarios_clientes')}}?cliente={!! base64_encode($cliente) !!}&_token={!! @csrf_token() !!}'">Limpar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
            <!-- form -->
            @if($agent->isMobile()!=false)
                <div class="container-xxl mt-4 mobile ">
                        <div class=" form-group px-2 mb-4">
                            <button class="btn btn-outline-success mb-2 " value="userlist" type="button" id="{{$cliente}}" onclick="newUser(this)">Cadastrar Usuario</button>
                        </div>
                </div>
                <div class="container-xxl mt-4 mobile ">
                    <div class="row gx-2">
                        <table class="table_list" id="myTable">
                            @for($i=0; $i<sizeof($users); $i++)
                                <tr class="card my-2" >
                                    <td class="w-80 d-flex justify-content-between card-header py-4 px-4">
                                        <div>
                                            <div class="text-secondary">Nome</div>
                                            <abbr  class="initialism" style="font-size: 12px ">{!! ucfirst($users[$i]->name) !!}</abbr>
                                        </div>
                                        <div class="px-2" style="width: 40%">
                                            <div class="text-secondary">E-mail</div>
                                            <abbr  class="initialism" style="font-size: 12px;word-break: break-all">{!! $users[$i]->email !!}</abbr>
                                        </div>
                                        <div class="py-2 px-2">
                                            <div class="text-secondary">ações</div>
                                            @if($users[$i]->active =='1')
                                                <button  class="btn btn-outline-secondary px-2" id="{{$users[$i]->id}}" value="desativar" type="button" onclick="desativar(this)"  name="submitbutton" data-bs-toggle="tooltip" data-bs-placement="top" title="Desativar">
                                                    <i class="fa fa-user-times" aria-hidden="true"></i></button>
                                            @else
                                                <button class="btn btn-outline-primary px-2" id="{{$users[$i]->id}}" value="ativar" type="button" onclick="ativar(this)" name="submitbutton"  data-bs-toggle="tooltip" data-bs-placement="top" title="Ativar"><i class="fa fa-toggle-on" aria-hidden="true"></i>
                                                </button>
                                            @endif
                                            <button class="btn btn-outline-danger px-2"  id="{{$users[$i]->id}}" value="excluir" type="button" onclick="excluir(this)"   name="submitbutton" data-bs-toggle="tooltip" data-bs-placement="top" title="Excuir"><i class="fa fa-user-times" aria-hidden="true"></i></button>
                                        </div>

                                    </td>
                                </tr>

                            @endfor
                        </table>

                        <div  class='col-md-10'>
                            @if($users instanceof \Illuminate\Pagination\AbstractPaginator)
                                {{$users->links()}}
                            @endif
                        </div>
                    </div>
                </div>
    </div>
            @else
                <!-- table button block -->
                <div class="container-xxl mt-4 mobile ">
                    <div class=" form-group px-2 mb-4">
                        <button class="btn btn-outline-success mb-2 " value="userlist" type="button" id="{{$cliente}}" onclick="newUser(this)">Cadastrar Usuario</button>
                    </div>
                    <table class="container" id="myTable">
                    @for($i=0; $i<sizeof($users); $i++)
                        <tr class="card my-2">
                            <td class="card-header">
                                <div class="float-container">
                                    <div class="float-child_alt">
                                        <div class="text-secondary">#</div>
                                        <div class="green"><abbr title="HyperText Markup Language" class="initialism">{!! $users[$i]->id !!}</abbr></div>
                                    </div>

                                    <div class="float-child_alt">
                                        <div class="text-secondary">Usuario</div>
                                        <div class="green"><abbr title="HyperText Markup Language" class="initialism">{!! $users[$i]->name !!}</abbr></div>
                                    </div>

                                    <div class="float-child_alt">
                                        <div class="text-secondary">Email</div>
                                        <div class="green"><abbr title="HyperText Markup Language" class="initialism">{!! $users[$i]->email !!}</abbr></div>
                                    </div>

                                    <div class="float-child_alt">
                                        <div class="text-secondary">ações</div>
                                        @if($users[$i]->active =='1')
                                            <button  class="btn btn-outline-secondary px-2" id="{{$users[$i]->id}}" value="desativar" type="button" onclick="desativar(this)"  name="submitbutton" >Desativar</button>
                                        @else
                                            <button class="btn btn-outline-primary px-2" id="{{$users[$i]->id}}" value="ativar" type="button" onclick="ativar(this)" name="submitbutton" >Ativar</button>
                                        @endif
                                        <button class="btn btn-outline-danger px-2"  id="{{$users[$i]->id}}" value="excluir" type="button" onclick="excluir(this)"   name="submitbutton">Excluir</button>
                                    </div>

                                </div>
                            </td>
                        </tr>

                    @endfor
                </table>
                <!-- table button block -->
                <div  class='col-lg-8'>
                    @if($users instanceof \Illuminate\Pagination\AbstractPaginator)
                        {{$users->links()}}
                    @endif
                </div>
            </div>
        </div>
        <!--content-->

      @endif


    <!-- partial -->
    <script  src="{{asset('/js/script.js')}}"></script>
    <script  src="{{asset('/js/main.js')}}"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js"
            integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy"
            crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
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


        function newUser(elem)
        {
            cliente= elem.id;
            url = "{{route('new_user')}}"
            window.location.href=url+"?cliente="+btoa(cliente)+"&token_="+"{!! @csrf_token() !!}";

        }

        function redirectByPost( parameters, inNewTab) {
            parameters = parameters || {};

            var form = document.createElement("form");
            form.id = "reg-form";
            form.name = "reg-form";
            form.action = "{{route('new_user')}}";
            form.method = "post";
            form.enctype = "multipart/form-data";

            var token = document.createElement('input')
            token.name = '_token'
            token.value = "{!! @csrf_token() !!}"
            form.appendChild(token)

            const input = document.createElement('input')
            input.name = 'cliente'
            input.value = parameters
            form.appendChild(input)

            document.body.appendChild(form);
            form.submit();
            document.body.removeChild(form);

            return false;
        }

        function getLista(cliente)
        {
            return getBack(cliente,false)
        }

        function getBack( parameters, inNewTab) {
            parameters = parameters || {};

            var form = document.createElement("form");
            form.id = "reg-form";
            form.name = "reg-form";
            form.action = "{{route('usuarios_clientes')}}";
            form.method = "post";
            form.enctype = "multipart/form-data";

            var token = document.createElement('input')
            token.name = '_token'
            token.value = "{!! @csrf_token() !!}"
            form.appendChild(token)

            const input = document.createElement('input')
            input.name = 'cliente'
            input.value = parameters
            form.appendChild(input)

            document.body.appendChild(form);
            form.submit();
            document.body.removeChild(form);

            return false;
        }


        function ativar(elem)
        {
            console.log(elem)
            let url ='{{ route("active_user")}}';
            window.location.href = url+"?id="+btoa(elem.id)+"&cliente="+"{{base64_encode($cliente)}}"+"&token_"+"{!! @csrf_token() !!}"

        }

        function desativar(elem)
        {
            console.log(elem.id)

            let url ='{{ route("deactive_user")}}';
            window.location.href = url+"?id="+btoa(elem.id)+"&cliente="+"{{base64_encode($cliente)}}"+"&token_"+"{!! @csrf_token() !!}"
        }

        function excluir(elem)
        {
            console.log(elem)

            let url ='{{ route("delete_user")}}';
            window.location.href = url+"?id="+btoa(elem.id)+"&cliente="+"{{base64_encode($cliente)}}"+"&token_"+"{!! @csrf_token() !!}"

        }
    </script>
</body>
</html>

