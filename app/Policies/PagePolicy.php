<?php

namespace App\Policies;

use App\Models\User;
use Flags\Flags;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Support\Facades\Auth;
use \Helpers\Helpers;

class PagePolicy
{
    use HandlesAuthorization;
    /**
     * Create a new policy instance.
     */

    public static function userCan($page)
    {   
        $user =Auth::user();
        if(strpos(strtolower(Helpers::getUserCompanyName(Auth::user()->id_cliente)),'low cost')===false)
        {
            if(isset($user->$page)!=true)
            {
                //echo '<script>history.back()</script>'; exit;
                echo '<script>window.location.href="'.route('list-news').'"</script>';
            }
            if(intval($user->$page)===0)
            {
                //echo '<script>history.back()</script>'; exit;
                echo '<script>window.location.href="'.route('list-news').'"</script>';
            }
        }


    }


}
