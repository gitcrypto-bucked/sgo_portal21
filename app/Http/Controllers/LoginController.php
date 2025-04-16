<?php

namespace App\Http\Controllers;

use App\Models\LoginModel;
use Illuminate\Auth\Events\Login;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
class LoginController extends Controller
{
    public function index()
    {
        return view('login');
    }

    public function userLogin(Request $request)
    {
        $remember= false;
        $credentials = [
            'email' => $request->typeEmailX,
            'password' => $request->typePasswordX
        ];
        $model = new LoginModel();
        if($model->partnerExists($request->typeUserTokenX)!=false)
        {
            if($request->flexCheckDefault=='0')
            {
                $remember = true;
            }
            if(Auth::attempt($credentials,$remember))
            {
                if(Auth::user()->active!=1)
                {
                    return redirect('/login')->with('error', 'Usuário/Senha inválidos.');
                }
                return redirect()->intended('/list-news');
            }
        }
        return redirect('/login')->with('error', 'Usuário/Senha inválidos.');

    }

    public function userLogout(Request $request)
    {
        Session::defaultRouteBlockLockSeconds(1);
        Session::invalidate();
        Session::flush();
        Auth::logout();
        Auth::guard('web')->logout();
        $request->session()->invalidate();
        $request->session()->flush();
        return Redirect::to('/login'); //redirect back to login
    }
}
