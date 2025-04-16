<?php

namespace App\Actions;

class Ticket_User
{
    /**
     * Create a new class instance.
     */
    public function get($ticketID, $user_id, $session_token)
    {
        $data = [
                "input" =>
                [
                    "tickets_id" => $ticketID, 
                    "users_id"=> $user_id,      
                    "type"=> 1
                ]
            ];

        
            $baseURL = "https://lcdesk.lowcost.com.br/apirest.php/";

            $app_token =   'P5DPl9uKZ3VpzicnEXPDMQA2D1K0zQbOUQxp61xQ';
            $curl = curl_init();
    
            curl_setopt_array($curl, array(
              CURLOPT_URL => $baseURL.'Ticket_User/',
              CURLOPT_SSL_VERIFYPEER=> false,
              CURLOPT_RETURNTRANSFER => true,
              CURLOPT_ENCODING => '',
              CURLOPT_MAXREDIRS => 10,
              CURLOPT_TIMEOUT => 0,
              CURLOPT_FOLLOWLOCATION => true,
              CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
              CURLOPT_CUSTOMREQUEST => 'POST',
              CURLOPT_POSTFIELDS =>json_encode($data),
     
              CURLOPT_HTTPHEADER => array(
                'app-token: '.$app_token,
                'session-token:'.$session_token,
                'Content-Type: application/json'
              ),
            ));
            curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
     
            $response = curl_exec($curl);
            curl_close($curl);
            return json_decode($response,true);
    }


}
