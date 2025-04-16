<div id="navbar-wrapper" >
        <nav class="navbar navbar-expand-lg navbar-light bg-light">
            <div class="container-fluid">
                <a href="#" class="navbar-brand" id="sidebar-toggle"><i class="fa fa-bars"></i></a>

                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item d-sm-flex nav-logo">
                        <a class="nav-link d-sm-flex mt-2 " aria-current="page" ><img src="{{asset('/logo/logo.png')}}"  class="logo  d-sm-flex " width="137"></a>
                    </li>
                </ul>
                <form class="d-flex ml-4 d-none d-lg-flex">
                    @if(Auth::check())
                        <div class="dropdown  mx-2 px-2" id="newsIcon">
                            <button data-mdb-button-init
                                    data-mdb-ripple-init data-mdb-dropdown-init class="btn "
                                    type="button"
                                    id="dropdownMenuButton"
                                    data-mdb-toggle="dropdown"
                                    aria-expanded="false"
                                        >
                                <i class="fa fa-bell " aria-hidden="true" ></i>
                                </button>
                            <ul class="dropdown-menu dropdown-menu-center" aria-labelledby="dropdownMenuButton"  id="list">
                            </ul>
                        </div>
                    @endif
            @if(Auth::check())
                <a class="btn  btn text-dark fw-bolder fs-6 px-5" type="submit" href="{{url('/logout')}}">Sair</a>
            @else
                <a class="btn  btn text-dark fw-bolder fs-6 px-5" type="submit" href="{{url('/login')}}">Login</a>
            @endif
    </form>
    </div>
    </nav>
    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"
            integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g=="
            crossorigin="anonymous"
            referrerpolicy="no-referrer">    </script>

    <script>
        $( document ).ready(function() {
            getNotifications();
        });

 

       async function getNotifications()
       {
            const response = await fetch(
               '{{route('list-notifications')}}',
               {
                   method: 'GET',
                   headers: {
                       'x-rapidapi-host': 'carbonfootprint1.p.rapidapi.com',
                       'x-rapidapi-key': 'your_api_key'
                   }
               }
           );
           const res = await response.text();
           if(res)
           {
                removeChild();
                addChild(res);
           }
       }


       function addChild(res)
       {
            resp = JSON.parse(res);

            const btn = document.getElementById('dropdownMenuButton');
            document.getElementById('newsIcon').style.display="block";

            const span = document.createElement('span');
                    span.id='badge'
                    span.innerHTML =  resp.data.length
                    span.classList.add('badge');
                    span.style.visibility="visible";
                    btn.append(span);

            const list = document.getElementById('list');

            if(resp.data.length>0)
            {
                for(let i=0; i<resp.data.length; i++)
                {
                    //console.log(resp.data[i]);
                    //console.log(resp.data[i]['type']);


                    if(resp.data[i]['type']==='news')
                    {
                        list.innerHTML+='<li><a class="dropdown-item" href="{{ route('list-news') }}" value="'+resp.data[i]['show_till']+'"  >'+resp.data[i]['notification']+'</a></li>';
                    }
                    if(resp.data[i]['type']==='system' && resp.data[i]['user_email']=='{!! Auth::user()->email; !!}')
                    {
                        list.innerHTML+='<li><a class="dropdown-item" value="'+resp.data[i]['show_till']+'"  >'+resp.data[i]['notification']+'</a></li>';
                    }
                }
                setTimeout(checkNotification(resp.data),500);
            }
       }



       function removeChild()
       {
           const myNode = document.getElementById("list");
           while (myNode.lastElementChild)
           {
               myNode.removeChild(myNode.lastElementChild);
           }
       }


       setTimeout(function (){
           let badge = document.getElementById('badge');
           if(badge != undefined)
           {
               badge.style.visibility="hidden";
           }
       }, 7500);


       function checkNotification(notif)
       {
           for(let i=0; i<notif.length; i++)
           {
               let dateNow =  Date.parse(new Date())
               let dateTill = Date.parse(notif[i]['show_till']);
               console.log(dateNow, dateTill)
               if(dateNow >=dateTill)
               {
                   hideNotifiction(notif[i]['id']);
               }

           }
       }

       async function hideNotifiction(id)
       {
           let formData  = new FormData()
           formData.append('_token','{!! @csrf_token() !!}');
           formData.append('csrf','{!! @csrf_token() !!}');
           formData.append('id',id);
           console.log(formData)
           const response = await fetch(
               '{{route('remove-notification')}}',
               {
                   method: 'POST',
                   headers: {
                       'x-rapidapi-host': 'carbonfootprint1.p.rapidapi.com',
                       'x-rapidapi-key': 'your_api_key'
                   },
                   body: formData
               }
           );
           const res = await response.text();

           if(res)
           {
               resp = JSON.parse(res);
               console.log(resp);

           }
       }

       const MINUTES = 1000 * 60 * 2
       const intervalID = setInterval(function(){
           removeChild();
           getNotifications();
       }, MINUTES);
       // you can to stop the execution by calling clearInterval()
       clearInterval(intervalID);

    </script>

      


