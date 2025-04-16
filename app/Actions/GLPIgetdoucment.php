<?php

namespace App\Actions;

class GLPIgetdoucment
{
    public function getDocument($session_token, $documentID)
    {
        //https://xxx/apirest.php/document/1023?alt=media" 
        $app_token = strlen(config('glpi.token')) ? config('glpi.token') :  'P5DPl9uKZ3VpzicnEXPDMQA2D1K0zQbOUQxp61xQ';

        $baseURL = "https://lcdesk.lowcost.com.br/apirest.php/";

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

        if(strpos($filename,'.pdf')!=false)
        {
            $filename = md5(time()).'.pdf';
        }
        if(strpos($filename,'.jpg')!=false)
        {
            $filename = md5(time()).'.jpg';
        }
        if(strpos($filename,'.jpeg')!=false)
        {
            $filename = md5(time()).'.jpeg';
        }
        if(strpos($filename,'.png')!=false)
        {
            $filename = md5(time()).'.png';
        }


        if(file_exists(public_path('document')."/".$filename))
        {
             unlink(public_path('document')."/".$filename);
        }
        //public_path('upload').'/',
        $myfile = fopen(public_path('document')."/".$filename, "w+");
        fwrite($myfile, $response);
        fclose($myfile);
        
        return $filename;

    }
}
