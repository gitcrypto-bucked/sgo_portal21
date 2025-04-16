<?php


namespace App\Actions;
use Illuminate\Support\Facades\Http;

class  ChangeProfileGLPI
{
    /**
     * Create a new class instance.
     */
    public function __construct()
    {
         
    }


    public function changeProfile($session_token):array
    {
        
        $app_token =   'P5DPl9uKZ3VpzicnEXPDMQA2D1K0zQbOUQxp61xQ';

        $curl = curl_init();

        curl_setopt_array($curl, array(
        CURLOPT_URL => 'https://lcdesk.lowcost.com.br/apirest.php/changeActiveProfile',
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_SSL_VERIFYPEER=> false,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'POST',
        CURLOPT_POSTFIELDS =>'{
        "profiles_id": 13
        }',
        CURLOPT_HTTPHEADER => array(
            'app-token: '.$app_token,
            'session-token:'.$session_token,
            'Content-Type: application/json'
        ),
        ));
        $response = curl_exec($curl);

        curl_close($curl);
        if(boolval($response)===true)
        {
            return ['status'=>200];
        }
        else
        {
           return  ['status'=>300];
        }
    }

  
}
