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
    <link rel="stylesheet" href="{{asset('/css/news.css')}}">
    {{--    <link rel="stylesheet" href="{{asset('/css/pagination.css')}}">--}}
    <meta http-equiv="Cache-control" content="max-age=10" />
    <meta http-equiv="Expires" content="Sat, 1 Apr 2022 05:00:00 GMT" />
    <?php
    header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
    header("Cache-Control: post-check=0, pre-check=0", false);
    header("Pragma: no-cache");
    header('Content-Type: text/html');
    ?>
    <meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate" />
    <meta http-equiv="Pragma" content="no-cache" />
    <meta http-equiv="Expires" content="0" />

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
    <div class="container-xxl mobile px-4 mt-4 ">
        <h2 class="content-title pageName">Noticias</h2>
        <p class="pageText">Gerenciar noticias</p>

        @if($agent->isMobile()!=false)
            @foreach($news as $k=> $v)
                <!--card-->
                <div class="card mb-3" style="width: 18rem;">
                    <img src="{{asset('storage/app/thumb_/'.$v->thumb)}}" class="card-img-top" alt="Sunset Over the Sea"/>
                    <div class="card-body">
                        <p class="mb-3 card-title border border-light" >
                            <small class="newsDate">{{Date('d/m/y', strtotime($v->created_at))}}&nbsp;</small><strong class="newsHeader text-break">{{$v->title}}</strong>
                        <p class="lh-0 newsText text-break">{{$v->intro}}
                        </p>
                        <button class="link mt-1 btn_link"  value="desativar" type="submit"  name="submitbutton" >...Desativar...</button>
                        <button class="link mt-1 btn_link"  value="excluir" type="submit" name="submitbutton">...Excluir...</button>
                    </div>
                <!--card -->
            @endforeach
        @else

        <div class="col-md-12 d-flex justify-content-left right-bck">
            <div class="registration-right">
                <div class="event-list">
                    <form id="news"  enctype="multipart/form-data" action="{{route('newsAction')}}" method="POST">
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
                        @foreach($news as $k=> $v)
                            <div class="card flex-row">
                                <input type="hidden" id="newsID" name="newsID" value="{{$v->id}}">
                                <img class="card-img-left img-fluid rounded" src="{{asset('storage/app/thumb_/'.$v->thumb)}}" alt="">
                                <div class="card-body">
                                    <p class="mb-3 card-title border border-light" >
                                        <small class="newsDate">{{Date('d/m/y', strtotime($v->created_at))}}&nbsp;</small><strong class="newsHeader text-break">{{$v->title}}</strong>
                                    <p class="lh-0 newsText text-break">{{$v->intro}}</p>
                                    <button class="link mt-1 btn_link"  value="desativar" type="submit"  name="submitbutton" >...Desativar...</button>
                                    <button class="link mt-1 btn_link"  value="excluir" type="submit" name="submitbutton">...Excluir...</button>
                                </div>
                            </div>
                        @endforeach
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- News block -->
</div>
<div  class='col-sm-4'>
    @if($news instanceof \Illuminate\Pagination\AbstractPaginator)
    {{$news->links()}}
    @endif
</div>
@endif
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
    function deactive(news)
    {
       const id_ = news.value
        alert(_id);

    }

    function remove(news)
    {
        const id_ = news.value
        alert(_id);
    }
</script>

</body>
</html>
