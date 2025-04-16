<?php

namespace App\Actions;

class GLPILink
{
    /**
     * Create a new class instance.
     */
    public function documentItem(array $data, $session_token)
    {
        $app_token = strlen(config('glpi.token')) ? config('glpi.token') :  'P5DPl9uKZ3VpzicnEXPDMQA2D1K0zQbOUQxp61xQ';
        $baseURL = "https://lcdesk.lowcost.com.br/apirest.php/";

        $curl = curl_init();
    
        curl_setopt_array($curl, array(
        CURLOPT_URL => $baseURL.'Document_Item',
        CURLOPT_SSL_VERIFYPEER=> false,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_SSL_VERIFYPEER=> false,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'POST',

        CURLOPT_POSTFIELDS => json_encode($data),
                    CURLOPT_HTTPHEADER => array(
            'app-token:'.$app_token,
            'session-token: '.$session_token,
            'csrf:'.md5(time()),
            'Content-Type: application/json'
        ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);
        $rel =json_decode($response,true);
        if(!isset($rel['id']))
        {
            #event(new \App\Events\GlPIerror(['error'=>'Erro ao relacionar documento com ticket','glpi_username'=>Auth::user()->glpi_username, 'email'=>Auth::user()->glpi_password ]));
            return false;
        }
        return $rel['id'];
    }
}
