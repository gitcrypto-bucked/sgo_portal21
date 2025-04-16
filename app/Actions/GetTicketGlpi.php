<?php

namespace App\Actions;
use Illuminate\Support\Facades\Http;

class GetTicketGlpi
{
 

    public function getTicket($session_token, $ticket_number)
    {
        $baseURL = "https://lcdesk.lowcost.com.br/apirest.php/";

        $app_token =   'P5DPl9uKZ3VpzicnEXPDMQA2D1K0zQbOUQxp61xQ';

        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => $baseURL.'Ticket/'.$ticket_number,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_SSL_VERIFYPEER=> false,
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
        return json_decode($response,true);

    }

  
}
