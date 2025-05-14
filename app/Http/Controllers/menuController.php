<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Flags\Flags;
use Illuminate\Support\Facades\Session;
use Helpers\Helpers;

class menuController extends Controller
{
    public function getMenu(): string
    {
        //pega o menu de usuario logado
        if (Auth::check())
        {
            $cliente = Helpers::getUserCompanyName(Auth::user()->id_cliente);
            switch ($cliente) {
                case 'lowcost': case 'Low cost estoque':
                    return $this->getLowCostMenu();
                    break;
                default:
                    return $this->getPartnerMenu();
                    break;
            }
        }
        return ''; //nothing in menu user not logged
    }

    protected function getLowCostMenu(): string
    {

        $menu = '<li class="">' . '<a href="' . route('list-news') . '" class=""><i class="fa fa-home"></i>Dashboard</a>' . '</li>' . "\r\n";
        $menu .= '<li class="">' . '<a href="' . route('add_news') . '" class=""><i class="fa fa-newspaper-o"></i>Cadastrar noticias</a>' . '</li>' . "\r\n";
        $menu .= '<li class="">' . '<a href="' . route('news-manager') . '" class=""><i class="fa fa-calendar-minus-o"></i>Gerenciar Noticias</a>' . '</li>' . "\r\n";
        $menu .= '<li class="">' . '<a href="' . route('chamados-upload') . '" class=""><i class="fa fa-upload"></i>Carga Chamados</a>' . '</li>' . "\r\n";
        $menu .= '<li class="">' . '<a href="' . route('invoice-upload') . '" class=""><i class="fa fa-upload"></i>Carga Faturamento</a>' . '</li>' . "\r\n";
        $menu .= '<li class="">' . '<a href="' . route('cliente_manager') . '" class=""><i class="fa fa-id-badge"></i>Gerenciar Clientes</a>' . '</li>' . "\r\n";

        $menu .= '<li class="d-sm-block d-lg-none">' . '<a href="' . route('logout') . '" class=""><i class="fa fa-sign-out" aria-hidden="true"></i>Sair</a>' . '</li>' . "\r\n";
        return ($menu);

    }

    private function getPartnerMenu(): string
    {
        $menu ='';
        $submenu = ' <div class="accordion accordion-flush" id="accordionFlushExample">
                 <div class="accordion-item">
                     <h2 class="accordion-header" id="flush-headingOne">
                         <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseOne" aria-expanded="false" aria-controls="flush-collapseOne">
                             <i class="fa fa-home" style="font-size: 24px; padding-right:8px; "></i> Dashboard
                         </button>
                     </h2>';

        if(isset(Auth::user()->dash_chamados) && boolval(Auth::user()->dash_chamados))
        {
            $submenu.='<div id="flush-collapseOne" class="accordion-collapse collapse" aria-labelledby="flush-headingOne" data-bs-parent="#accordionFlushExample">
                     <div class="accordion-body">
                         <ul id="accordion_list">
                             <li class="">' . '<a href="' . route('dash_chamados') . '" class="text-white" style="word-break: break-all; font-size: 13px "><i class="fa fa-bar-chart"></i>&nbsp;Chamados </a>' . '</li>
                         </ul>
                     </div>
                 </div>';
        }
        if(isset(Auth::user()->dash_faturamento) && boolval(Auth::user()->dash_faturamento))
        {
            $submenu.='<div id="flush-collapseOne" class="accordion-collapse collapse" aria-labelledby="flush-headingOne" data-bs-parent="#accordionFlushExample">
                     <div class="accordion-body">
                         <ul id="accordion_list">
                             <li class="">' . '<a href="' . route('dash_faturamento') . '" class="text-white" style="word-break: break-all;font-size: 13px "><i class="fa fa-bar-chart"></i>&nbsp;Faturamento </a>' . '</li>
                         </ul>
                     </div>
                 </div>';
        }
        if(isset(Auth::user()->dash_inventario) && boolval(Auth::user()->dash_inventario))
        {
            $submenu.=  '<div id="flush-collapseOne" class="accordion-collapse collapse" aria-labelledby="flush-headingOne" data-bs-parent="#accordionFlushExample">
                     <div class="accordion-body">
                         <ul id="accordion_list">
                             <li class="">' . '<a href="' . route('dash_inventario') . '" class="text-white" style="word-break: break-all; font-size: 13px "><i class="fa fa-bar-chart"></i>&nbsp;Inventário </a>' . '</li>
                         </ul>
                     </div>
                 </div>';
        }
        $submenu.= '</div>
         </div> ';

        $menu .=$submenu;

        if(isset(Auth::user()->chamados) && boolval(Auth::user()->chamados))
        {
            $menu .= '<li class="">' . '<a href="' . route('chamados') . '" class=""><i class="fa fa-cogs" aria-hidden="true"></i></i>Chamados</a>' . '</li>' . "\r\n";
        }
        if(isset(Auth::user()->faturamento) && boolval(Auth::user()->faturamento))
        {
            $menu .= '<li class="">' . '<a href="' . route('faturamento') . '" class=""><i class="fa fa-money"></i>Faturamento</a>' . '</li>' . "\r\n";
        }
        if(isset(Auth::user()->inventario) && boolval(Auth::user()->inventario))
        {
            $menu .= '<li class="">' . '<a href="' . route('inventario') . '" class=""><i class="fa fa-tasks"></i>Inventario</a>' . '</li>' . "\r\n";
        }
        if(isset(Auth::user()->tracking) && boolval(Auth::user()->tracking))
        {
            $menu .= '<li class="">' . '<a href="' . route('tracking') . '" class=""><i class="fa fa-truck" aria-hidden="true"></i>Tracking</a>' . '</li>' . "\r\n";
        }

        $menu .= '<li class="">' . '<a href="' . route('list-news') . '" class=""><i class="fa fa-newspaper-o"></i>Noticias</a>' . '</li>' . "\r\n";
        $menu .= '<li class="d-sm-block d-lg-none">' . '<a href="' . route('logout') . '" class=""><i class="fa fa-sign-out" aria-hidden="true"></i>Sair</a>' . '</li>' . "\r\n";
        if(!empty(\session('original_user')))
        {
            $menu .= '<hr>';
            $menu .= '<li class="">' . '<a href="' . route('switch_back') . '" class=""><i class="fa fa-arrow-left" aria-hidden="true"></i>Lowcost</a>' . '</li>' . "\r\n";

        }

        return $menu;
    }




    public function getDesktopLogo(): string
    {
        $menuHeader = '';
        if (Auth::check()) {
            $menuHeader = '<a href = "#" class="m-0" ><img src ="' . ( Helpers::getUserCompanyLogo(Auth::user()->id_cliente)) . '" width = "137" class=" ml-1 logo_desktop" style="border: 1px solid" ></a >
            <p class="text-black lh-1  m-1 userDesktop" >
                <strong class="text-white ml-2" >' .
                Auth::user()->name.
                '</strong>
                <br >
                <p class="text-white mt-1 lh-1 d-none d-md-block"  style="font-weight: 500">'
                .(ucwords(Helpers::getUserCompanyNameFormated(Auth::user()->id_cliente))) .
                '</p >
            </p>';
        } else {
            $menuHeader = '<a href = "#" class="m-0" ><img src = "' . asset("/empresas/lowcost.svg") . '" width = "137" class=" ml-2 logo_desktop" ></a >
                <p class="text-black lh-1  m-1 userDesktop" >
                    <br >
                    <strong class="text-black mt-0 lh-1" > LowCost</strong >
                </p >';

        }
        return $menuHeader;
    }


    public function getMobileLogo(): string
    {
        $menuHeader = '';
        if(Auth::check())
        {
            $menuHeader= '<div class="mobile_user">
                <div class="">
                    <a  class="userDisplay" aria-expanded="false">
                        <div style="float: left;padding-left:15px">
                            <img src="'.( Helpers::getUserCompanyLogo(Auth::user()->id_cliente)) .'" alt="" width="32" height="32"  id="userComapny"  >
                        </div>
                        &nbsp;<strong class="userName">'.Auth::user()->name.'</strong><br>'.ucfirst(Helpers::getUserCompanyNameFormated(Auth::user()->id_cliente)).'
                    </a>
                </div>
            </div>';
        }
        else
        {
            $menuHeader=  '<div class="mobile_user">
                <div class="">
                    <a  class="userDisplay" aria-expanded="false">
                        <div style="float: left;padding-left:15px">
                            <img src="'.asset("empresas/lowcost.png").'" alt="" width="32" height="32"  id="userComapny"  >
                        </div>
                    </a>
                </div>
            </div>';
        }


        return $menuHeader;
    }




}
