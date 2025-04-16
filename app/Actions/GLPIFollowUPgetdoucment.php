<?php


namespace App\Actions;

class GLPIFollowUPgetdoucment
{
    public function getDocument($session_token, $documentID)
    {

        $baseURL = "https://lcdesk.lowcost.com.br/apirest.php/";

        $app_token =   'P5DPl9uKZ3VpzicnEXPDMQA2D1K0zQbOUQxp61xQ';
        
        
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://lcdesk.lowcost.com.br/apirest.php/Document/'.$documentID,
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
                'Content-Type: Content-type:application/pdf',
                'Content-type: image'
            ),
        ));
        $response = curl_exec($curl);
        curl_close($curl);
        $file = json_decode($response,true);

        if(!isset($file['filename']))
        {
            return null;
        }


        $filename = $file['filename'];
        unset($response);

        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://lcdesk.lowcost.com.br/apirest.php/Document/'.$documentID.'?alt=media',
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
                'Content-Type: Content-type:application/pdf',
                'Content-type: image/*'
            ),
        ));
        $response = curl_exec($curl);
        curl_close($curl);


        //public_path('upload').'/',
        $myfile = fopen(public_path('download')."/".$filename, "w+");
        fwrite($myfile, $response);
        fclose($myfile);
        
        return $filename;
    }
}