<!DOCTYPE html>
<html lang="pt_BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="Ti team &amp; Low Cost contributors">
    <meta name="generator" content="Pedro Henrique & Washington">
    <meta http-equiv='cache-control' content='no-cache'>
    <meta http-equiv='expires' content='0'>
    <meta http-equiv='pragma' content='no-cache'>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta http-equiv="refresh" content="300">
    <title>Portal LowCost Login</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
          integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH"
          crossorigin="anonymous">
    <link rel="stylesheet" href="{{asset('/css/login.css')}}">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <link rel='stylesheet' href='https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css'>

</head>
<body>
<section class="gradient-custom">
    <div class="container py-2 h-100">
        <div class="row d-flex justify-content-center align-items-center h-100">
            <!--      col-12 col-md-8 col-lg-6-->
            <div class="col-md-7 col-lg-4 col-xl-4 ">
                <div class="card bg-dark-alt text-white " style="border-radius: 1rem;">
                    <div class="card-body p-5 text-center">

                        <div class="mb-md-5 mt-0 pb-0">
                            <div>
                                <img src="{{asset('/logo/lowcost.svg')}}">
                            </div>
                            <h2 class=" mb-2 text-uppercase">LOWCOST</h2>
                            <p class="text-white mb-5"><strong>Portal do Cliente</strong></p>
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
                            <form id="formLogin" method="POST" action="{{route('userLogin')}}" autocomplete="off" >
                                @csrf

                                <div data-mdb-input-init class="form-outline form-white mb-4" style="text-align: left !important;">
                                    <label class="form-label" for="typeUserTokenX" style="display: none">Token</label>
                                    <input type="text" id="typeUserTokenX"  name="typeUserTokenX" class="form-control form-control-lg " autocomplete="off"  placeholder="Token de usuario"
                                           required
                                        inputmode="numeric"
                                        maxlength="8"
                                        minlength="8"
                                    />
                                </div>

                                <div data-mdb-input-init class="form-outline form-white mb-4" style="text-align: left !important;">
                                    <input type="email" id="typeEmailX" name="typeEmailX"  autocomplete="off"  class="form-control form-control-lg" placeholder="E-mail" required/>
                                    <label class="form-label" for="typeEmailX" style="display: none">Email</label>
                                </div>

                                <div data-mdb-input-init class="form-outline form-white mb-4 " style="text-align: left !important;">
                                    <div class="input-group mb-0">
                                        <input type='password'  autocomplete="off" class="form-control myInput form-control-lg" placeholder="Senha" id="typePasswordX"
                                               name="typePasswordX" required>
                                        <span class="input-group-text toggleSwitch" onclick="myFunction()">
                                        <i class="fa fa-eye-slash" id="togglePassword"  style="cursor: pointer"></i>
                                     </span>
                                    </div>
                                    <label class="form-label mt-0 lh-1" for="typePasswordX"  style="display: none">Password</label>
                                    <div class="form-check ml-auto text-left pt-2" style="text-align: left !important;">
                                        <input class="form-check-input" type="checkbox" value="0" id="flexCheckDefault" name="flexCheckDefault"/>
                                        <label class="form-check-label text-left" for="flexCheckDefault">Lembrar-me</label>
                                    </div>
                                </div>

                                <button data-mdb-button-init data-mdb-ripple-init class="btn btn-success round-btn tn-lg px-5" type="submit">Login</button>

                            </form>
                            <p class="small mb-5 pb-sm-2 "><a class="text-white forgot" href="{{route('forgot-password')}}">Esqueci minha senha</a></p>
                            <div class="d-flex justify-content-center text-center mt-4 pt-1">
                                <a href="https://www.instagram.com/lowcost_official/" target="_blank" class="text-white"><img src="{{asset('social/instagram.png')}}" class="linkedin px-2"></a>
                                <a href="https://www.linkedin.com/company/lowcost/mycompany/"  target="_blank" class="text-white"><img src="{{asset('/social/linkedin.png')}}" class="linkedin px-2"></a>
                                <a href="https://web.facebook.com/lowcostoficial/?_rdc=1&_rdr" target="_blank" class="text-white"><img src="{{asset('/social/facebook.png')}}" class="linkedin px-2"></a>
                            </div>
                            <a href="https://www.lowcost.com.br/" target="_blank" class="text-white">www.lowcost.com.br</a>
                        </div>

                        <div style="display: none; visibility: hidden">
                            <p class="mb-0">Don't have an account? <a href="#!" class="text-white-50 fw-bold">Sign Up</a>
                            </p>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js"
        integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy"
        crossorigin="anonymous">

</script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-browser/0.1.0/jquery.browser.min.js"
        integrity="sha512-7IUk8ZcM82NUtcQv8gBFQTbz0Z+yXiGQyOj+YvSOTv3ZQbxEBYrs4zmY4rrm4/opSN1Xv/oGONv5uCSqiYZy4g=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script  src="{{asset('js/main.js')}}"></script>

<script>
    function myFunction() {
        var x = document.getElementById("typePasswordX");
        var toggle = document.getElementById('togglePassword');
        if (x.type === "password")
        {
            x.type = "text";
            $("#togglePassword").removeClass("fa fa-eye-slash");
            $("#togglePassword").addClass('fa fa-eye');
        }else
        {
            x.type = "password";
            $("#togglePassword").removeClass("fa fa-eye");
            $("#togglePassword").addClass('fa fa-eye-slash');
        }
    }

    setTimeout(function (){
        const error = document.getElementById('error');
        if(error!=undefined)
        {
            error.style.display="none";
        }
    },6200);

    $(function () {
        $("input[name='typeUserTokenX']").on('input', function (e) {
            $(this).val($(this).val().replace(/[^0-9]/g, ''));
        });
    });

    function onlynum() {
        let fm = document.getElementById("form2");
        let ip = document.getElementById("num");
        let tag = document.getElementById("value");
        let res = ip.value;

        if (res != '') {
            if (isNaN(res)) {

                // Set input value empty
                ip.value = "";

                // Reset the form
                fm.reset();
                return false;
            } else {
                return true
            }
        }
    }



</script>

</body>
</html>
