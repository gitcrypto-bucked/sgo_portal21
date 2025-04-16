<?php

declare(strict_types=1);


namespace App\Listeners;

use App\Events\GLPILogin;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;


class GlpidoLogin
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(GLPILogin $event)
    {
        $username = $event->username;
        $password = $event->password;
        return  $this->doGLPI_login($username,$password);
    }


    protected function doGLPI_login($username,$password)
    {
        $baseURL = "https://lcdesk.lowcost.com.br/apirest.php";

        $app_token =   'P5DPl9uKZ3VpzicnEXPDMQA2D1K0zQbOUQxp61xQ';

        $ch = curl_init($baseURL."/initSession");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

        $headers = array();
        $headers[] = 'Content-Type: application/json';
        $headers[] = 'App-Token: '.$app_token;

        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch,CURLOPT_POSTFIELDS , json_encode([
            "login"=> $username,
            "password"=> $password,
            "profiles_id" =>'13'
        ]) );

        $result = curl_exec($ch);
        if (curl_errno($ch)) {
            echo 'Error:' . curl_error($ch); exit;
        }
        curl_close($ch);
        return json_decode($result,true);
    }
}
