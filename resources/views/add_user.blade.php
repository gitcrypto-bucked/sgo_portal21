
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
    <div class="container-xxl px-4 mt-4 ">
        <h2 class="content-title pageName">Cadastro de Usuario</h2>
        <p class="pageText">Crie cadastro e usuarios com acesso ao portal.</p>
        <p  class=" pageName" >  Cliente: {!! @ucwords(($cliente))!!}</p>

        <div class="row gx-2 gy-3 mt-3 ">
            <!-- News Block -->
                        <div class="col-md-10 mx-auto">
                            <form id="registerForm" method="POST"  autocomplete="off" action="{{url('/add_user')}}" class="form-floating">
                                @if(Session::has('error'))
                                    <div class="alert alert-success bg-danger text-white" id="error">
                                        {{ Session::get('error')}}
                                    </div>
                                @endif
                                @if (session('success'))
                                    <div class="alert alert-success text-white bg-success" id="success">
                                        {{ session('success') }}
                                    </div>
                                @endif
                                @csrf
                                <div class="form-group row">
                                    <div class="col-sm-6 ">
                                        <div class="form-floating mb-3">
                                            <input  class="form-control" id="empresa" name="empresa"  required readonly value="{{ ucwords(($cliente)) }}">
                                            <label for="empresa">Empresa</label>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-floating mb-3">
                                            <input type="text" class="form-control" id="name" name="name" required >
                                            <label for="name">Nome</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-sm-6">
                                        <div class="form-floating mb-3">
                                            <input type="email" class="form-control" id="email" name="email" required >
                                            <label for="email">E-mail</label>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-floating mb-3">
                                            <input type="email" class="form-control" id="confirm_email" name="confirm_email" required >
                                            <label for="email">Confirmação de email</label>
                                        </div>
                                    </div>

                                </div>
                                <div class="form-group row">
                                    <div class="col-sm-6">
                                        <div class="form-floating mb-3">
                                            <input type="text" class="form-control" id="centrocusto" name="centrocusto"  >
                                            <label for="centrocusto">Centro de Custo</label>
                                        </div>
                                    </div>

                                    <div class="col-sm-6 @if(strtolower($cliente)=='lowcost') d-none @endif ">
                                        <label for="acesso">Controle de Acesso</label>

                                        <div class="form-floating mb-3">
                                            <div class="form-check form-switch">
                                                <input class="form-check-input" type="checkbox" id="dash_faturamento"  name="dash_faturamento" >
                                                <label class="form-check-label" for="dash_faturamento">Dashbboard Faturamento</label>
                                            </div>
                                            <div class="form-check form-switch">
                                                <input class="form-check-input" type="checkbox" id="dash_chamados"  name="dash_chamados" >
                                                <label class="form-check-label" for="dash_chamados">Dashboard Chamados</label>
                                            </div>
                                            <div class="form-check form-switch">
                                                <input class="form-check-input" type="checkbox" id="dash_inventario" name="dash_inventario" >
                                                <label class="form-check-label" for="flexSwitchCheckDisabled">Dashboard Invantario</label>
                                            </div>
                                            <div class="form-check form-switch">
                                                <input class="form-check-input" type="checkbox" id="chamados" name="chamados" >
                                                <label class="form-check-label" for="chamados">Chamados</label>
                                            </div>
                                            <div class="form-check form-switch">
                                                <input class="form-check-input" type="checkbox" id="abrir_chamado" name="abrir_chamado" >
                                                <label class="form-check-label" for="abrir_chamado">Abrir chamados</label>
                                            </div>
                                            <div class="form-check form-switch">
                                                <input class="form-check-input" type="checkbox" id="chamados_details" name="chamados_details" >
                                                <label class="form-check-label" for="chamados_details">Detalhe chamados</label>
                                            </div>
                                            <div class="form-check form-switch">
                                                <input class="form-check-input" type="checkbox" id="faturamento"  name="faturamento"  >
                                                <label class="form-check-label" for="faturamento">Faturamento</label>
                                            </div>
                                            <div class="form-check form-switch">
                                                <input class="form-check-input" type="checkbox" id="faturamento_details"  name="faturamento_details"  >
                                                <label class="form-check-label" for="faturamento_details">Detalhe faturamento</label>
                                            </div>
                                            <div class="form-check form-switch">
                                                <input class="form-check-input" type="checkbox" id="inventario"   name="inventario">
                                                <label class="form-check-label" for="inventario">Inventário</label>
                                            </div>
                                            <div class="form-check form-switch">
                                                <input class="form-check-input" type="checkbox" id="inventario_details"  name="inventario_details">
                                                <label class="form-check-label" for="inventario_details">Detalhes inventário </label>
                                            </div>

                                            <div class="form-check form-switch">
                                                <input class="form-check-input" type="checkbox" id="tracking" name="tracking" >
                                                <label class="form-check-label" for="tracking">Rastreamento</label>
                                            </div>
                                            <div class="form-check form-switch">
                                                <input class="form-check-input" type="checkbox" id="tracking_details" name="tracking_details" >
                                                <label class="form-check-label" for="tracking_details">Detalhes rastreamento</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                    <button type="submit" class="btn btn-primary mb-2"  >Cadastrar</button>
                                    <button type="reset" class="btn btn-danger btn-lg-danger bg-danger mb-2" >Cancelar</button>
                                    <button class="btn btn-outline-success mb-2" value="voltar" type="button"  id="{!! $cliente !!}" onclick="window.location.href='{{route('usuarios_clientes')}}?cliente={!! base64_encode($cliente) !!}&_token={!! @csrf_token() !!}'"" >Voltar</button>
                            </form>
                        </div>
                    </div>

            <!-- News block -->
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
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>

<script>




</script>
</body>
</html>
