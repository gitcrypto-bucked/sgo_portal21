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

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
          integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH"
          crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.14.1/themes/base/jquery-ui.min.css" integrity="sha512-TFee0335YRJoyiqz8hA8KV3P0tXa5CpRBSoM0Wnkn7JoJx1kaq1yXL/rb8YFpWXkMOjRcv5txv+C6UluttluCQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.14.1/themes/base/theme.min.css" integrity="sha512-lfR3NT1DltR5o7HyoeYWngQbo6Ec4ITaZuIw6oAxIiCNYu22U5kpwHy9wAaN0vvBj3U6Uy2NNtAfiaKcDxfhTg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel='stylesheet' href='https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css'>
    <link rel="stylesheet" href="{{asset('/css/style.css')}}">
    <link rel="stylesheet" href="{{asset('/css/dropdown.css')}}">
    <link rel="stylesheet" href="{{asset('/css/search.css')}}">
    <link rel="stylesheet" href="{{asset('/css/list.css')}}">
    <link rel="stylesheet" href="{{asset('/css/rating.css')}}">
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.14.1/themes/base/jquery-ui.css">
    <link rel="stylesheet" href="{{asset('/css/sweetalert.css')}}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <link href="http://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="stylesheet" href="{{asset('/css/chamados.css')}}">

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
        <h2 class="content-title pageName">Gestão de Chamados</h2>
        <p class="pageText"></p>

    </div>
    <!--table-->
    @if($agent->isMobile()!=false)
        <div class="container-xxl mt-4 mobile ">
            <div class="card details">
                <div class="card-body">
                    <h5 class="card-title"><span class="bolder px-4" style="font-size: 14px">Chamado:&nbsp; {!!$details[0]->numero_chamado_interno!!}</span></h5>
                    <h6 class="card-subtitle mb-2 text-muted"></h6>
                    <p class="card-text">
                            <ul style="list-style: none">
                                    <li class="py-1"><span class="bolder" style="font-size: 12px">Serial:&nbsp; {!!$details[0]->numero_serial!!}</span></li>
                                    <li class="py-1"><span class="" style="font-size: 12px;color:green;font-weight: 470">Sla:&nbsp; {!! ucfirst(@$details[0]->sla.' PRAZO') !!}</span></li>

                                    <li class="py-1">
                                        <span class="" style="font-size: 12px">Centro de Custo:&nbsp; {!! strlen(@$details[0]->cdc)? @$details[0]->cdc : "8570063200115" !!}</span>
                                    </li>
                                    <li class="py-1">
                                        <span class="" style="font-size: 12px">Abertura:&nbsp; {!! date('d/m/Y H:i', strtotime($details[0]->data_criacao)) !!}</span>
                                    </li>
                                    <li class="py-1">
                                        <span class="" style="font-size: 12px">Aberto por:&nbsp; {!! strlen(@$details[0]->aberto)? @$details[0]->aberto : "Alberto Ramos" !!}</span>

                                    </li>
                                    <li class="py-1">
                                        <span class="" style="font-size: 12px">Centro de Custo:&nbsp; {!! strlen(@$details[0]->cdc)? @$details[0]->cdc : "8570063200115" !!}</span>
                                    </li>
                                    <li class="py-1">
                                        <span class="" style="font-size: 12px">Departamento:&nbsp; {!! strlen(@$details[0]->tipo_chamado)? @$details[0]->tipo_chamado: "Recursos Humanos" !!}</span>
                                    </li>
                                    <li class="py-1">
                                        <span class=""  style="font-size: 12px">Data de Fechamento:&nbsp; {!! str_replace('.','/',$details[0]->data_fechamento) !!}</span>
                                    </li>
                                    <li class="py-2">

                                        <div class="rating" style="">
                                            <input type="radio" id="star5" name="rating" value="5" /><label for="star5" title="Rocks!">5 stars</label>
                                            <input type="radio" id="star4" name="rating" value="4" /><label for="star4" title="Pretty good">4 stars</label>
                                            <input type="radio" id="star3" name="rating" value="3" /><label for="star3" title="Meh">3 stars</label>
                                            <input type="radio" id="star2" name="rating" value="2" /><label for="star2" title="Kinda bad">2 stars</label>
                                            <input type="radio" id="star1" name="rating" value="1" checked/><label for="star2" title=" bad">1 stars</label>
                                        </div>
                                    </li>
                            </ul>
                    </p>

                </div>
            </div>
        </div>
        <div class="container-xxl mt-4 px-4">
            <div class="card-body mt-2" data-mdb-perfect-scrollbar-init style="position: relative; height: 400px;">
                <div class="d-flex justify-content-between">
                </div>
                <div class="d-flex flex-row justify-content-start" ;">
                <div style="background-color:#E3F0E8!important; height:84px ; width:126.97px; border-radius:13px;">
                    <p class="text">AR</p>
                    <p   class='date' style=" word-break: break-all;margin-top: -20px!important; ;font-size: 8px"> {!! date('d/m/y H:i') !!}</p>
                </div>
                    <div>
                        <p class="small p-2 ms-3 mb-3 rounded-3 bg-body-tertiary px-1" style="word-break: break-all;background-color:#E3F0E8!important; ">
                            Pessoal, minha HP LaserJet P1102w, com pouquissimo tempo de uso, e depois de ficar alguns meses paradas, começou a imprimir dessa forma abaixo, manchando todas páginas impressas, sem motivo aparente
                            <img src='{{ asset('/img/eb90445d1f64d832d30fe76bd78271ac.png')}}' class="details-img"  style="width: 80% !important;">
                        </p>
                    </div>
                </div>
            </div>
        </div>
    @else
        <!--end table-->
        <div class="container-xxl mt-4 mobile ">
            <div class="row">
                <div class="col-lg details mt-2">
                    <table style='margin-top:10px; background-color: transparent !important;padding:2px ' class="table ">
                        <tr style="background-color: transparent !important;">
                            <td >
                                <p><span class="bolder">Chamado:&nbsp; {!!$details['id']!!}</span></p>
                            </td>
                            <td >
                                <p><span class="bolder">Serial:&nbsp; {!! @$details['serial']!!}</span></p>
                            </td>
                            <td >
                               <p> Avaliação: </p>
                            </td>
                            <td >
                                <div class="rating" style="margin-top: -8px !important">
                                    <input type="radio" id="star5" name="rating" value="5" /><label for="star5" title="Rocks!">5 stars</label>
                                    <input type="radio" id="star4" name="rating" value="4" /><label for="star4" title="Pretty good">4 stars</label>
                                    <input type="radio" id="star3" name="rating" value="3" /><label for="star3" title="Meh">3 stars</label>
                                    <input type="radio" id="star2" name="rating" value="2" checked/><label for="star2" title="Kinda bad">2 stars</label>
                                    <input type="radio" id="star1" name="rating" value="1" /><label for="star1" title="Sucks big time">1 star</labe/>
                                </div>
                            </td>
                            <td>
                                <a href="{{route('chamados')}}" style="color:black
                                "><i class="fa fa-backward fa-lg" aria-hidden="true" ></i></a>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <p><span class="">Aberto por:&nbsp; {!! ucfirst(Auth::user()->name) !!}</span></p>
                            </td>
                            <td colspan="2">
                                <p><span class="">Centro de Custo:&nbsp; {!! strlen(@$details->cdc)? @$details->cdc : "8570063200115" !!}</span></p>
                            </td>
                            <td>
                                <p><span class="">Data abertura:&nbsp; {!! date('d/m/Y H:i', strtotime($details['date'])) !!}</span></p>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <p><span class="">SLA:&nbsp; @if(@$details['slas_id_ttr']==0){!! 'DENTRO DO PRAZO' !!} @else {!! "FORA DO PRAZO" !!} @endif</span></p>
                            </td>
                            <td colspan="2">
                                <p><span class="">Departamento:&nbsp; </span></p>
                            </td>
                            <td>
                                <p><span class="">Data de Fechamento:&nbsp; {!! date('d/m/Y H:i', strtotime($details['date_mod'])) !!}</span></p>
                            </td>
                        </tr>
                    </table>

                </div>
            </div>
        </div>

        <div class="container-xxl mobile" style="margin-top: 30px !important;">

          <div class="col-lg-12">

            <ul class="list-unstyled">

              <li class="d-flex justify-content-between mb-4 " >
                <div style="background-color:#E3F0E8!important; height:84px ; width:126.97px; border-radius:13px;">
                    <p class="text">@php( \Helpers\Helpers::generateUserSigmaName(Auth::user()->name))</p>
                    <p   class='date'style=" word-break: break-all"> {!! date('d/m/Y H:i', strtotime($details['date'])) !!}</p>
                </div>
                <div class="card " style="background-color:#E3F0E8!important;border-radius:0px !important; width:55vw !important">
                  <div class="card-header d-flex justify-content-between p-3" style="background-color:#E3F0E8!important; height:1px !important">

                  </div>
                  <div class="card-body" style="border-radius:0px !important;">
                    <p  style=" word-break: break-all;">
                        {!! strip_tags($details['content']) !!}
                      </p>
                      <ul class="list-group list-group-horizontal" >
                            @for($i=0; $i< sizeof($media); $i++)
                                <li class="list-group-item"> <a href="{{ url('document/'.$media[$i]) }}" target="_blank" > Ver {{\Helpers\Helpers::fileType($media[$i])}} </a></li>
                            @endfor
                      </ul>
                  </div>
                </div>
              </li>
          
              @if(!empty($follow))
                    @for($i =0; $i<sizeof($follow); $i++)
                        <li class="d-flex justify-content-between mb-4 " >
                            <div style="background-color:#E3F0E8!important; height:84px ; width:126.97px; border-radius:13px;">
                                <p class="text">@php( \Helpers\Helpers::generateUserSigmaName($follow[$i]['user']) )</p>
                                {{-- @if(!isset($FollowFiles[0]['files']['users'][0]))
                                   
                                @else
                                    <p class="text">@php( \Helpers\Helpers::generateUserSigmaName($FollowFiles[0]['files']['users'][0]) )</p>
                                @endif --}}
                                <p   class='date'style=" word-break: break-all"> {!! date('d/m/Y H:i', strtotime( $follow[$i]['date_mod'])) !!}</p>
                            </div>   
                            <div class="card " style="background-color:#E3F0E8!important;border-radius:0px !important; width:55vw !important">
                                <div class="card-header d-flex justify-content-between p-3" style="background-color:#E3F0E8!important; height:1px !important">
                
                                </div>
                                <div class="card-body" style="border-radius:0px !important;">
                                    <p  style=" word-break: break-all;">
                                        {!! strip_tags(html_entity_decode(strval($follow[$i]['content']))) !!}
                                    </p>
                                
                                <ul class="list-group list-group-horizontal" >
                                @if(isset($FollowFiles[$i]['files']['filenames']))
                                    @for($x=0; $x < sizeof($FollowFiles[$i]['files']['filenames']); $x++)
                                        @if($follow[$i]['id']===$FollowFiles[$i]['id'])
                                                <li class="list-group-item"> <a href="{{ url('download/'.$FollowFiles[$i]['files']['filenames'][$x]) }}" target="_blank" >Ver {{\Helpers\Helpers::fileType($FollowFiles[$i]['files']['filenames'][$x]) }} </a></li>
                                            
                                        @endif
                                    @endfor  
                                @endif
                                </ul>
                            </div>      
                            </div>
                        </li> 
                    @endfor   
              @endif

              @if(!empty($solution))
                    @for($i =0; $i<sizeof($solution); $i++)
                    <li class="d-flex justify-content-between mb-4 " >
                        <div style="background-color:#b1d4e0!important; height:84px ; width:126.97px; border-radius:13px;">
                            <p class="text">@php( \Helpers\Helpers::generateUserSigmaName($solution[$i]['user']) )</p>

                            {{-- <p class="text" style="color:#2e8bc0 !important">@php( \Helpers\Helpers::generateUserSigmaName($SoluttionFiles[$i]['files']['users'][0]) )</p> --}}
                            <p   class='date'style=" word-break: break-all"> {!! date('d/m/Y H:i', strtotime( $solution[$i]['date_mod'])) !!}</p>
                        </div>   
                        <div class="card " style="background-color:#b1d4e0!important;border-radius:0px !important; width:55vw !important">
                            <div class="card-header d-flex justify-content-between p-3" style="background-color:#b1d4e0!important; height:1px !important">
            
                            </div>
                            <div class="card-body" style="border-radius:0px !important;">
                                <p  style=" word-break: break-all;">
                                    {!! strip_tags(html_entity_decode(strval($solution[$i]['content']))) !!}
                                </p>
                            
                            <ul class="list-group list-group-horizontal" >
                                @if(isset($SoluttionFiles[$i]['files']['filenames']))
                                    @for($x=0; $x < sizeof($SoluttionFiles[$i]['files']['filenames']); $x++)
                                        @if($solution[$i]['id']===$SoluttionFiles[$i]['id'])
                                                <li class="list-group-item"> <a href="{{ url('download/'.$SoluttionFiles[$i]['files']['filenames'][$x]) }}" target="_blank" >Ver Anexo </a></li>
                                            
                                        @endif
                                    @endfor 
                                @endif     
                            </ul>
                        </div>      
                        </div>
                    </li> 
                @endfor   
              @endif
          
            </ul>

          </div>

        </div>
        
          <div class="container-xxl mobile @if(!empty($solution)) d-none @else d-block @endif" style="margin-top: 30px !important;">

          <div class="col-lg-12">

            <ul class="list-unstyled">
              <li class="d-flex justify-content-between mb-4 " >
                <div style=" height:84px ; width:126.97px; border-radius:13px;">
                </div>
                <div class="card " style="background-color:#E3F0E8!important;border-radius:0px !important; width:55vw !important">
                  <div class="card-header d-flex justify-content-between p-3" style="background-color:#E3F0E8!important; height:1px !important">

                  </div>
                  <div class="card-body" style="border-radius:0px !important;">
                    <p  style=" word-break: break-all;">
                        Adicionar ao chamado
                    </p>
                    <form method="POST" action="{{route('update_chamado')}}" class="form-floating  mt-3" enctype="multipart/form-data" autocomplete="off">
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
                        <input type="hidden" id='numero_chamado' name='numero_chamado' value='{!!$details['id']!!}'>
                        <div class="form-floating mb-3">
                            <textarea  class="form-control" id="descricao" name="descricao"  required   rows="10" style="height: 160px"></textarea>
                            <label for="centrocusto">Descriçao</label>
                        </div>
    
                        <div class="form-floating mb-3">
                            <input class="form-control" type="file" id="formFile" name="files[]" accept="image/jpeg,image/gif,image/png,application/pdf,image/x-eps .csv, application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-excel""  multiple onchange="checkFiles(this.files)">
                        </div>
    
    
                        <div class="mb-3 form-group">
                            <button type="submit" class="btn btn-primary mb-2"  >Atualizar</button>
                            <button type="reset" class="btn btn-danger btn-lg-danger bg-danger mb-2" >Cancelar</button>
                        </div>
                    </form>
                  </div>
                </div>
              </li>

              {{-- <li class="d-flex justify-content-between mb-4">
                <img src="https://mdbcdn.b-cdn.net/img/Photos/Avatars/avatar-6.webp" alt="avatar"
                  class="rounded-circle d-flex align-self-start me-3 shadow-1-strong" width="60">
                <div class="card">
                  <div class="card-header d-flex justify-content-between p-3">
                    <p class="fw-bold mb-0">Brad Pitt</p>
                    <p class="text-muted small mb-0"><i class="far fa-clock"></i> 12 mins ago</p>
                  </div>
                  <div class="card-body">
                    <p class="mb-0">
                      Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut
                      labore et dolore magna aliqua.
                    </p>
                  </div>
                </div>
              </li> --}}


          </div>

        </div>

        </div>
        <div class="container-xxl mt-4 mobile ">
            <div class="row">
                <div  class='col-lg-8'>
                    @if($details instanceof \Illuminate\Pagination\AbstractPaginator)
                        {{$details->withQueryString()->links()}}
                    @endif
                </div>
            </div>
        </div>

        <!--wrapper-->

    @endif
</div>
</body>
<script  src="{{asset('/js/script.js')}}"></script>
<script  src="{{asset('/js/main.js')}}"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js"
        integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy"
        crossorigin="anonymous"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<script src="https://code.jquery.com/ui/1.14.1/jquery-ui.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.i18n/1.0.9/jquery.i18n.js" integrity="sha512-OU7TUd3qODSbwnF5mHouW66/Yt54mzh58k+rxfJili7AunMl5wbF2D8kLGTGuUv5xM2MfylWZOPZaqOKpf7dZg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script><script>
    $.datepicker.setDefaults( $.datepicker.regional[ "pt-BR" ] );

    $( "#inputGroupSelect01" ).datepicker();
    $( "#inputGroupSelect02" ).datepicker();



    $(document).ready(function() {
    $("form#ratingForm").submit(function(e)
    {
        e.preventDefault(); // prevent the default click action from being performed
        if ($("#ratingForm :radio:checked").length == 0) {
            $('#status').html("nothing checked");
            return false;
        } else {
            $('#status').html( ' Youpicked ' + $('input:radio[name=rating]:checked').val() );
        }
    });
});

function checkFiles(files)
    {       
        console.log(files); 
        if(files.length===3) {

        let list = new DataTransfer;
        for(let i=0; i<3; i++)
           list.items.add(files[i]) 

            document.getElementById('files').files = list.files
        }       
        else if(files.length<3) 
        {
            alert("Escolha somente 3 arquivos"); return;
        }    
    }     
</script>
</html>
