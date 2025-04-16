window.onload = function ()
{
    setTimeout(function (){

        const sucess = document.getElementById('sucess');
        const error = document.getElementById('error');

        if(sucess!=undefined)
        {
            sucess.style.display="none"
        }

        if(error!=undefined)
        {
            error.style.display="none";
        }

    }, 6500);
}


