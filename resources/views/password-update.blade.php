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
        <h2 class="content-title pageName">Cadastrar senha de acesso</h2>
        <p class="pageText">Crie sua senha de acesso para o Portal LowCost</p>
        <div class="row mt-3 ">
            <!-- News Block -->
            <div class="col-md-8 col-lg-6 col-xl-4 ">
                <form id="formLogin" method="POST" action="{{route('updatePassword')}}">
                    @csrf
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
                    <div class="divider d-flex align-items-left my-4">
                        <input type="hidden" id="token" name="token" value="{{@$token}}">
                    </div>
                    <div data-mdb-input-init class="form-outline mb-4">
                        <label class="form-label" for="company">Empresa</label>
                        <input type="text" id="company" name="company" class="form-control form-control-lg"
                               maxlength="191" value="{{@$user[0]->company}}" readonly />
                    </div>
                    <div data-mdb-input-init class="form-outline mb-4">
                        <label class="form-label" for="name">Nome</label>
                        <input type="text" id="name" name="name" class="form-control form-control-lg"
                               value="{{@$user[0]->name}}"  readonly />
                    </div>
                    <div data-mdb-input-init class="form-outline mb-4">
                        <label class="form-label" for="empresa">E-mail</label>
                        <input type="text" id="email" name="email" class="form-control form-control-lg"
                               maxlength="191" value="{{@$user[0]->email}}" readonly />
                    </div>
                    <!-- Email input -->
                    <div data-mdb-input-init class="form-outline mb-4">
                        <label class="form-label" for="form3Example4">Senha</label>
                        <input type="password" id="password" name='password' class="form-control form-control-lg"
                               placeholder="Informe sua senha" required aria-required="true"/>
                    </div>
                    <!-- Password input -->
                    <div data-mdb-input-init class="form-outline mb-3">
                        <label class="form-label" for="form3Example4">Confirme sua senha</label>
                        <input type="password" id="passwordConfirmation" name='passwordConfirmation' class="form-control form-control-lg"
                               placeholder="Informe sua senha" required aria-required="true"/>

                    </div>
                    <div class="d-flex justify-content-between align-items-center">
                        <!-- Checkbox -->
                        <div class="form-check mb-0">
                            <input class="form-check-input me-2" type="checkbox" value="" name='remember_token' id="remember_token" />
                            <label class="form-check-label" for="remember_token" style="font-size: 14px">
                                Mostar Senha?
                            </label>
                        </div>
                    </div>
                    <div class="text-center text-lg-start mt-4 pt-2">
                        <button  type="submit"  class="btn btn-primary">Salvar</button>
                    </div>
                </form>
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
    setTimeout(function (){
        const error = document.getElementById('error');
        if(error!=undefined)
        {
            error.style.display="none";
        }
    },6200);

    const togglePassword = document.getElementById('remember_token');
    const password = document.getElementById('password');
    const cfpassword = document.getElementById('passwordConfirmation');

    togglePassword.addEventListener("click", function () {
        // toggle the type attribute
        const type = password.getAttribute("type") === "password" ? "text" : "password";
        password.setAttribute("type", type);
        cfpassword.setAttribute("type", type);
        // toggle the icon
    });



</script>
</body>
</html>
