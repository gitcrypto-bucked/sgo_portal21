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
    <link rel="stylesheet" href="{{asset('/css/search.css')}}">
    <link rel="stylesheet" href="{{asset('/css/list.css')}}">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.14.1/themes/base/jquery-ui.css">
        <link rel="stylesheet" href="{{asset('/css/graph.css')}}">

    <link rel="stylesheet" href="https://code.jquery.com/ui/1.14.1/themes/base/jquery-ui.css">
    <style>
      .highcharts-figure,
        .highcharts-data-table table {
            min-width: 320px;
            max-width: 1200px;
            height:600px;
            margin: 1em auto;
        }

        #container {
            height: 600px;
        }

        .highcharts-data-table table {
            font-family: Verdana, sans-serif;
            border-collapse: collapse;
            border: 1px solid #ebebeb;
            margin: 10px auto;
            text-align: center;
            width: 100%;
            max-width: 500px;
        }

        .highcharts-data-table caption {
            padding: 1em 0;
            font-size: 1.2em;
            color: #555;
        }

        .highcharts-data-table th {
            font-weight: 600;
            padding: 0.5em;
        }

        .highcharts-data-table td,
        .highcharts-data-table th,
        .highcharts-data-table caption {
            padding: 0.5em;
        }

        .highcharts-data-table thead tr,
        .highcharts-data-table tbody tr:nth-child(even) {
            background: #217480;
        }

        .highcharts-data-table tr:hover {
            background: #2f588d;
        }

        .highcharts-description {
            margin: 0.3rem 10px;
        }

    </style>
    <script src="https://code.highcharts.com/highcharts.js"></script>
    <script src="https://code.highcharts.com/modules/exporting.js"></script>
    <script src="https://code.highcharts.com/modules/export-data.js"></script>
    <script src="https://code.highcharts.com/modules/accessibility.js"></script>
    <script src="https://code.highcharts.com/i18n/nb-NO.js"></script>

  
</head>
<body>
<!-- partial:index.partial.html -->
<div id="wrapper">
    <!--sidebar-->
    @include('components.sidebar')

    <!--sidebar-->
    <!--navbar -->
    @include('components.navwrapper')
    <!--content-->
        <!--content-->
    <div class="container-xxl mt-4 mobile ">
        <h2 class="content-title pageName" style="color: {!! \Helpers\Helpers::getTextClienteColor(Auth::user()->id_cliente)!!} !important">Dashboard - Faturamento</h2>
        <form method="POST" action="{!! route('dash_faturamento') !!}" >
            <div class="row gx-5 gy-3 mt-3 ">
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
                <div class="col-md-4 ">
                    <div class="mb-3">
                        <label for="exampleInputEmail1" class="form-label">Data Inicial:</label>
                        <div class="input-group mb-3">
                            <label class="input-group-text" for="inputGroupSelect01"><i class="fa fa-calendar" aria-hidden="true"></i></label>
                            <input type="text" id="inputGroupSelect01" name='dataInicio' class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-default" onchange="getStartDate(this)" value="@if(@$dataInicio!='') {!!  date("m/d/Y", strtotime(@$dataInicio)) !!} @endif">
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="mb-3">
                        <label for="exampleInputEmail1" class="form-label">Data Final:</label>
                        <div class="input-group mb-3">
                            <label class="input-group-text" for="inputGroupSelect02"><i class="fa fa-calendar" aria-hidden="true"></i></label>
                            <input type="text" id="inputGroupSelect02" name='dataFim' class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-default" onclick='getEndDate(this)'  value="@if(@$dataFim!='') {!! date("m/d/Y", strtotime(@$dataFim)) !!} @endif">
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                     <div class="mb-3">
                        <label for="exampleInputEmail1" class="form-label">Data Final:</label>
                        <div class="input-group mb-3">
                            <button type="submit"  class="btn btn-primary">Filtrar</button>
                        </div>
                     </div>        
                </div>    
            </div>
        </form>
    </div>
    <!--table-->
    <!--end table-->
    <div class="container-xxl mt-4 mobile ">
        <div class="d-sm-flex align-items-center mb-3">
				{{-- <a href="#" class="btn btn-dark me-2 text-truncate" id="daterange-filter">
					<i class="fa fa-calendar fa-fw text-white text-opacity-50 ms-n1"></i> 
					<span style="text-transform: capitalize !important" id='calendar'>@if($dataInicio!='') {!! date("d-M-y", strtotime($dataInicio)) !!} @endif - @if($dataFim!='') {!!  date("d-M-y", strtotime($dataFim)) !!} @endif</span>
					<b class="caret ms-1 opacity-5"></b>
				</a> --}}
				{{-- <div class="text-gray-600 fw-bold mt-2 mt-sm-0">compared to <span id="daterange-prev-date">1 May - 8 May 2025</span></div> --}}
			</div>
        <div class="row">
            <div class="col-4">
                {{-- <iframe title="Dash GERDAU LowCost.v2" id="embedContainer"
                        style="width: 100%; height: 82vh; clip-path: polygon(0% 0%, 100% 0%, 100% calc(100% - 36px), 0% calc(100% - 36px));" src="https://app.powerbi.com/view?r=eyJrIjoiNzI3NTY2YTMtNTNlNy00OGJmLWFhZmQtNWE3MGJhNGNlM2U1IiwidCI6ImUwMjVlMGQ5LTE3ZjMtNDY0Mi05YzkxLTVmNmE4OTcyZTM2ZSJ9&pageName=ReportSectiona4b6d1d3587b678040b4" frameborder="0" allowFullScreen="true"></iframe> --}}
                 <div class="card bg-primary text-white">
                        <div class="card-body">
                           <section id="piecontainer">
                           </section>
                        </div>
                    </div>
            </div>
            <div class="col-4">
                    <!--- -->
                    <div class="card bg-dark text-white">
                        <div class="card-body">
                            This is some text within a card body.
                        </div>
                    </div>
            </div>    
             <div class="col-4">
                    <!--- -->
                    <div class="card bg-secondary text-white">
                        <div class="card-body">
                            This is some text within a card body.
                        </div>
                    </div>
            </div>    
        </div>
    </div>
    <div class="container-xxl mt-4 mobile ">
        <div class="row">
            <div class="col">
                <div class="card   text-white" style="background-color: #eeede7 !important">
                    <div class="card-body" >
                       <section id="container">
                        </section>
                    </div>
                </div>    
            </div>
        </div>
    </div>        

    <div class="footer"></div>
 
    <!--wrapper-->
</div>
</body>
<script  src="{{asset('/js/script.js')}}"></script>
<script  src="{{asset('/js/main.js')}}"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js"
        integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy"
        crossorigin="anonymous"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.js" integrity="sha512-+k1pnlgt4F1H8L7t3z95o3/KO+o78INEcXTbnoJQ/F2VqDVhWoaiVml/OEHv9HsVgxUaVW+IbiZPUJQfF/YxZw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>


<script>
    jQuery.fn.load = function (callback) {
        var el = $(this);

        el.on('load', callback);

        return el;
    };

</script>
</html>
