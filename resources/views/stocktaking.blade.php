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
  <!--navbar -->
  <!--content-->
  <div class="container-fluid px-4 mt-4 ">
    <h2 class="content-title pageName">Inventário de Equipamentos e Serviços</h2>
    <p class="pageText">Veja abaixo todos os equipamentos e serviços que você possui com a LowCost. Utilzie a busca para encontrar os itens especificos!</p>
    <div class="row gx-5 gy-3 mt-3 ">

      <div class="col-md-6">
        <label for="cliente" class="form-label d-none d-lg-block">Cliente</label>
        <select  class="form-select" id="cliente" name="cliente">
          <option value="0" >Cliente</option>
          <option class="text-muted">Open this select menu</option>
        </select>
      </div>
      <div class="col-md-6">
        <label for="localidade" class="form-label d-none d-lg-block">Localidade</label>
        <select  class="form-select" id="localidade" name="localidade">
          <option value="0" >Localidade</option>
          <option class="text-muted">Open this select menu</option>
        </select>
      </div>

      <div class="col-md-6">
        <label for="modelo" class="form-label d-none d-lg-block">Modelo</label>
        <select  class="form-select" id="modelo" name="modelo">
          <option value="0" >Modelo</option>
          <option class="text-muted">Open this select menu</option>
        </select>
      </div>
      <div class="col-sm-3">
        <label for="serial" class="form-label d-none d-lg-block">Serial</label>
        <select  class="form-select" id="serial" name="serial">
          <option value="0" >Serial</option>
          <option class="text-muted">Open this select menu</option>
        </select>
      </div>
      <div class="col-sm-3">
        <label for="ced" class="form-label d-none d-lg-block">Centro de Custo</label>
        <select  class="form-select" id="ced" name="ced" >
          <option value="0">Centro de Custo</option>
          <option class="text-muted">Open this select menu</option>
        </select>
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
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>

<script>

  //show labels into select for mobile

  function showFirstOptionOnMobile() {
    // Detecta se o dispositivo é móvel (simplificado)
    const isMobile = window.innerWidth <= 768;

    if (isMobile)
    {
        document.getElementById("serial").options.selectedIndex= 0;
        $('#serial').children('option[value="0"]').css('display','block');
        document.getElementById("localidade").options.selectedIndex= 0;
        $('#localidade').children('option[value="0"]').css('display','block');
        document.getElementById("modelo").options.selectedIndex= 0;
        $('#modelo').children('option[value="0"]').css('display','block');
        document.getElementById("cliente").options.selectedIndex= 0;
        $('#cliente').children('option[value="0"]').css('display','block');
        document.getElementById("ced").options.selectedIndex= 0;
        $('#ced').children('option[value="0"]').css('display','block');
    }
    else
    {
       document.getElementById("serial").options.selectedIndex= 1;
       $('#serial').children('option[value="0"]').css('display','none');
       document.getElementById("localidade").options.selectedIndex= 1;
       $('#localidade').children('option[value="0"]').css('display','none');
       document.getElementById("modelo").options.selectedIndex= 1;
       $('#modelo').children('option[value="0"]').css('display','none');
       document.getElementById("cliente").options.selectedIndex= 1;
       $('#cliente').children('option[value="0"]').css('display','none');
       document.getElementById("ced").options.selectedIndex= 1;
       $('#ced').children('option[value="0"]').css('display','none');

    }

  }

  window.onload= function(){
    showFirstOptionOnMobile();
  };

  window.addEventListener('resize', function(event) {
    showFirstOptionOnMobile();
  }, true);



</script>
</body>
</html>
