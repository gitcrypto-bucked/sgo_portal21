@php($menu = new \App\Http\Controllers\menuController())
<aside id="sidebar-wrapper" >
    <div class="sidebar-brand">
        <!--desktop display -->
        {!! $menu->getDesktopLogo() !!}
        <!--desktop display end-->
        <!--user display on mobile -->
        {!! $menu->getMobileLogo() !!}
        <!--user display on mobile end-->
    </div>
    <ul class="sidebar-nav">
      {!! $menu->getMenu() !!}
    </ul>
    <br>
</aside>
<script>

    window.onload = function (){

        let parentDiv = document.getElementById("accordionFlushExample");
        if(parentDiv.childNodes[1].childNodes.length===0 | parentDiv.childNodes[1].childNodes.length==2)
        {
            parentDiv.style.display="none";
        }
        else if(parentDiv.childNodes[1].childNodes.length>2)
        {
            parentDiv.style.display="block";
        }
        console.log(parentDiv.childNodes[0].childNodes.length);

        console.log(parentDiv.childNodes[1].childNodes.length);
    }
</script>
