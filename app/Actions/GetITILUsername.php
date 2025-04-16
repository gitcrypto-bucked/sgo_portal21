<?php


namespace App\Actions;


class GetITILUsername
{
    public function getUsername($userID, $session_token)
    {
        $baseURL = "https://lcdesk.lowcost.com.br/apirest.php/";

        $app_token =   'P5DPl9uKZ3VpzicnEXPDMQA2D1K0zQbOUQxp61xQ';
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://lcdesk.lowcost.com.br/apirest.php/User/'.$userID,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_SSL_VERIFYPEER=> false,
            CURLOPT_IPRESOLVE=> CURL_IPRESOLVE_V4,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'GET',
            CURLOPT_HTTPHEADER => array(
                'app-token: '.$app_token,
                'session-token:'.$session_token,
                'Content-Type: application/json'
            ),
        ));

        $response = curl_exec($curl);
        curl_close($curl);
        $resp = json_decode($response,true);
        
        return $resp['firstname'].' '.$resp['realname'];
    }
}