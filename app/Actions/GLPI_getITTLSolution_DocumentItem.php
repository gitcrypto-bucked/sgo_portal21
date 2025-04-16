<?php

namespace App\Actions;
use Helpers\Helpers;


class GLPI_getITTLSolution_DocumentItem
{

    public function getDocument_Item( $href, $session_token,$user_glpi)
    {

       

        $baseURL = "https://lcdesk.lowcost.com.br/apirest.php/";

        $app_token =   'P5DPl9uKZ3VpzicnEXPDMQA2D1K0zQbOUQxp61xQ';

        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => $href,
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
        if($response==="[]" || empty($response))
        {
            return null;
        }

        $resp = json_decode($response,true);

        $documentURL = [];
        $users = [];

        for($x =0; $x<sizeof($resp); $x++)
        {
            for($i=0; $i< sizeof($resp[$x]['links']); $i++)
            {
                if($resp[$x]['links'][$i]['rel']==='Document')
                {
                    array_push($documentURL , $resp[$x]['links'][$i]['href']);
                }
                //Deprecated 13/04/25
                // if(@$resp[$x]['links'][$i]['rel']==='User')
                // {
                //     #array_push($users , $resp[$x]['links'][$i]['href']);
                //     array_push($users , $this->getUsername($resp[$x]['links'][$i]['href'], $session_token));
                // }
            }
           
        }


        if(Helpers::same($users)===true)
        {
            $respUser = $users[0];
        }

        $filesNames = [];
        for($i=0; $i< sizeof($documentURL); $i++)
        {
            $curl = curl_init();
            curl_setopt_array($curl, array(
                CURLOPT_URL => $documentURL[$i],
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
    
            $json = json_decode($response,true);

            $filename = $json['filename'];

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
            
            $curl = curl_init();
            curl_setopt_array($curl, array(
                CURLOPT_URL => $documentURL[$i]."?alt=media",
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

            $myfile = fopen(public_path('download')."/".$filename, "w+");
            fwrite($myfile, $response);
            fclose($myfile);

            array_push($filesNames, $filename);
        }

      

        return ['filenames'=>$filesNames,'users'=> $users];
        
    }


    
    protected function getUsername($href, $session_token)
    {
        $baseURL = "https://lcdesk.lowcost.com.br/apirest.php/";

        $app_token =   'P5DPl9uKZ3VpzicnEXPDMQA2D1K0zQbOUQxp61xQ';
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => $href,
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