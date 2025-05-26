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

    <title>Portal LowCost</title>
    <!--  <link rel='stylesheet' href='https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css'>-->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
          integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH"
          crossorigin="anonymous">
    <link rel='stylesheet' href='https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css'>
    <link rel="stylesheet" href="{{asset('/css/style.css')}}">
    <link rel="stylesheet" href="{{asset('/css/dropdown.css')}}">
    <link rel="stylesheet" href="{{asset('/css/search.css')}}">
    <link rel="stylesheet" href="{{asset('/css/list.css')}}">
    <script src="https://cdn.canvasjs.com/ga/canvasjs.min.js"></script>
    <script src="https://cdn.canvasjs.com/ga/canvasjs.stock.min.js"></script>
    <script src="https://code.highcharts.com/highcharts.js"></script>
    <script src="https://code.highcharts.com/modules/exporting.js"></script>
    <script src="https://code.highcharts.com/modules/export-data.js"></script>
    <script src="https://code.highcharts.com/modules/accessibility.js"></script>
    <script src="https://code.highcharts.com/i18n/nb-NO.js"></script>
    <script src="https://code.highcharts.com/modules/data.js"></script>
    <script src="https://code.highcharts.com/modules/drilldown.js"></script>
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
    <div class="container-xxl mt-4 mobile ">
        <h2 class="content-title pageName" style="color: {!! \Helpers\Helpers::getTextClienteColor(Auth::user()->id_cliente)!!} !important">Dashboard - Chamados</h2>
        <form method="POST" action="{!! route('dash_chamados') !!}" >
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
                            <input type="text" id="inputGroupSelect01" name='dataInicio' class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-default" onchange="getStartDate(this)" value="@if($dataInicio!='') {!!  date("m/d/Y", strtotime($dataInicio)) !!} @endif">
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="mb-3">
                        <label for="exampleInputEmail1" class="form-label">Data Final:</label>
                        <div class="input-group mb-3">
                            <label class="input-group-text" for="inputGroupSelect02"><i class="fa fa-calendar" aria-hidden="true"></i></label>
                            <input type="text" id="inputGroupSelect02" name='dataFim' class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-default" onclick='getEndDate(this)'  value="@if($dataFim!='') {!! date("m/d/Y", strtotime($dataFim)) !!} @endif">
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
            <div class="col-md-4">
                {{-- <iframe title="Dash GERDAU LowCost.v2" id="embedContainer"
                        style="width: 100%; height: 82vh; clip-path: polygon(0% 0%, 100% 0%, 100% calc(100% - 36px), 0% calc(100% - 36px));" src="https://app.powerbi.com/view?r=eyJrIjoiNzI3NTY2YTMtNTNlNy00OGJmLWFhZmQtNWE3MGJhNGNlM2U1IiwidCI6ImUwMjVlMGQ5LTE3ZjMtNDY0Mi05YzkxLTVmNmE4OTcyZTM2ZSJ9&pageName=ReportSectiona4b6d1d3587b678040b4" frameborder="0" allowFullScreen="true"></iframe> --}}
                 <div class="card bg-primary text-white" style="background-color: #e3e8f0 !important">
                        <div class="card-body">
                           <section id="piecontainer" style="height: 370px; width: 100%;">
                           </section>
                        </div>
                    </div>
            </div>
            <div class="col-4">
                    <!--- -->
                    <div class="card bg-dark text-white">
                        <div class="card-body">
                             <canvas id="piecontainer2">
                           </canvas>
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
    
        <div class="container-xxl mt-4 mobile ">
        <div class="row">
            <div class="col">
                <div class="card   text-white" style="background-color: #c0c0c0 !important">
                    <div class="card-body" >
                       <section id="container2">
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
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>

<script>
        function getStartDate(elem)
        {
            
        }

        function getEndDate(elem)
        {
           
        }

</script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<script src="https://code.jquery.com/ui/1.14.1/jquery-ui.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.i18n/1.0.9/jquery.i18n.js" integrity="sha512-OU7TUd3qODSbwnF5mHouW66/Yt54mzh58k+rxfJili7AunMl5wbF2D8kLGTGuUv5xM2MfylWZOPZaqOKpf7dZg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script type="text/javascript">
    window.onload = function()
    {
        loadMainGraph();
        getPieChartTotais();
        getPieChartMesTotal();
    }


    function getPieChartTotais()
    {
       let totals = {!!  @json_encode($totals,true) !!} ;

       let aberto = parseInt(totals['ABERTO']);
       let fechado =parseInt(totals['FECHADO']); 
       
        var chart = new CanvasJS.Chart("piecontainer", {
            width: 385,
            animationEnabled: true,
            title:{
                text:'Total Chamados Abertos x Fechados ',
                horizontalAlign: "center",
                fontSize: 18,
            },
            data: [{
                type: "doughnut",
                startAngle: 30,
                //innerRadius: 60,
                indexLabelFontSize: 13,
                indexLabel: "{label}",
                toolTipContent: "<b>{label}:</b> {y}",
                dataPoints: [
                    { y: aberto, label: "Abertos" },
                    { y: fechado, label: "Fechados"}
                ]
            }]
        });
        chart.render();
    }


    function loadMainGraph()
    {
        Highcharts.chart('container', {
            chart: {
                type: 'column'
            },
            title: {
                text: 'Chamados'
            },
           
            xAxis: {
                categories: {!!  @json_encode($datelist,true)!!},
                crosshair: true,
                accessibility: {
                    description: 'Datas'
                }
            },
            yAxis: {
                min: 0,
                title: {
                    text: ''
                }
            },
            tooltip: {
                valueSuffix: 'Total'
            },
            plotOptions: {
                column: {
                    pointPadding: 0.2,
                    borderWidth: 0,
                    pointWidth:40
                }
            },
            series: [
                {
                    name: 'Aberto',
                    data: {!!  @json_encode($abertos,true)!!}
                },
                {
                    name: 'Fechados',
                    data: {!!  @json_encode($fechados,true)!!}
                }
            ]
        });
    }

    function getPieChartMesTotal()
    {
         Highcharts.chart('container2', {
            chart: {
                type: 'line'
            },
            title: {
                text: 'Chamados'
            },
           
            xAxis: {
                categories: {!!  @json_encode($meses,true)!!},
                crosshair: true,
                accessibility: {
                    description: 'Datas'
                }
            },
            yAxis: {
                min: 0,
                title: {
                    text: ''
                }
            },
            tooltip: {
                valueSuffix: 'Total'
            },
            plotOptions: {
                column: {
                    pointPadding: 0.2,
                    borderWidth: 0,
                    pointWidth:40
                }
            },
            series: [
                {
                    name: 'Aberto',
                    data: {!!  @json_encode($chamadosAbertos,true)!!}
                }
               
            ]
        });
    }
</script>    
<script>
    $.datepicker.setDefaults( $.datepicker.regional[ "pt-BR" ] );
    $( "#inputGroupSelect01" ).datepicker();
    $( "#inputGroupSelect02" ).datepicker();
</script>

</html>
