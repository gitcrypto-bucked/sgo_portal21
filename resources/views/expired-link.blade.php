<!DOCTYPE html>
<html lang="pt_BR" >
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="Ti team &amp; Low Cost contributors">
    <meta name="generator" content="Pedro Henrique & Washington">
    <title>Portal LowCost </title>
    <!--  <link rel='stylesheet' href='https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css'>-->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
          integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH"
          crossorigin="anonymous">
    <link rel='stylesheet' href='https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css'>
    <link rel="stylesheet" href="{{asset('/css/style.css')}}">
    <link rel="stylesheet" href="{{asset('/css/dropdown.css')}}">
</head>
<body>
<!-- partial:index.partial.html -->
<div id="wrapper">
    <!--sidebar-->
    @include('components.sidebar')

    <!--sidebar-->
    <!--navbar -->
    @include('components.navwrapper')
{{--    <div id="navbar-wrapper" >--}}
{{--        <nav class="navbar navbar-expand-lg navbar-light bg-light">--}}
{{--            <div class="container-fluid">--}}
{{--                <a href="#" class="navbar-brand" id="sidebar-toggle"><i class="fa fa-bars"></i></a>--}}

{{--                <ul class="navbar-nav me-auto mb-2 mb-lg-0">--}}
{{--                    <li class="nav-item d-sm-flex nav-logo">--}}
{{--                        <a class="nav-link d-sm-flex mt-2 " aria-current="page" ><img src="{{asset('/logo/logo.png')}}"  class="logo  d-sm-flex " width="137"></a>--}}
{{--                    </li>--}}
{{--                </ul>--}}
{{--                <form class="d-flex ml-4 d-none d-lg-flex">--}}
{{--                    <div class="dropdown  mx-2 px-2">--}}
{{--                        <button data-mdb-button-init--}}
{{--                                data-mdb-ripple-init data-mdb-dropdown-init class="btn "--}}
{{--                                type="button"--}}
{{--                                id="dropdownMenuButton"--}}
{{--                                data-mdb-toggle="dropdown"--}}
{{--                                aria-expanded="false"--}}
{{--                        >--}}
{{--                            <i class="fa fa-bell" aria-hidden="true"></i>--}}
{{--                        </button>--}}
{{--                        <ul class="dropdown-menu dropdown-menu-center" aria-labelledby="dropdownMenuButton" >--}}
{{--                            <li><a class="dropdown-item" href="#">Action</a></li>--}}
{{--                            <li><a class="dropdown-item" href="#">Another action</a></li>--}}
{{--                            <li><a class="dropdown-item" href="#">Something else here</a></li>--}}
{{--                        </ul>--}}
{{--                    </div>--}}
{{--                    @if(Auth::check())--}}
{{--                        <a class="btn  btn text-dark fw-bolder fs-6 px-5" type="submit" href="{{url('/logout')}}">Sair</a>--}}
{{--                    @else--}}
{{--                        <a class="btn  btn text-dark fw-bolder fs-6 px-5" type="submit" href="{{url('/login')}}">Login</a>--}}
{{--                    @endif--}}
{{--                </form>--}}

{{--            </div>--}}
{{--        </nav>--}}
{{--    </div>--}}
    <!--navbar -->
    <!--content-->
    <div class="container-fluid px-4 mt-4 ">
        <h2 class="content-title pageName">Link expirado</h2>
        <p class="pageText">Seu link de redefinição de senha expirou, se você ainda deseja redefinir sua senha esquecida, vá para a página de senha esquecida</p>
        <div class="row gx-5 gy-3 mt-3 px-2">
            <!-- News Block -->
            <div class="col-sm-3">
                <a class="btn btn-primary btn-lg" href="{{url('/')}}">Home</a>
            </div>
            <!-- News block -->
        </div>
    </div>
    <!--content-->


</div>
<!-- partial -->
<script  src="{{asset('/js/script.js')}}"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js"
        integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy"
        crossorigin="anonymous">

</script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>

<script>

    //show labels into select for mobile




</script>
</body>
</html>
