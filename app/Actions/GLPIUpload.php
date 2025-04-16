<?php

namespace App\Actions;
use Illuminate\Support\Facades\Auth;


class GLPIUpload
{
    /**
     * Create a new class instance.
     */
  

    public function glpiUpload($arquivo, $session_token)
    {
        
        $app_token = strlen(config('glpi.token')) ? config('glpi.token') :  'P5DPl9uKZ3VpzicnEXPDMQA2D1K0zQbOUQxp61xQ';

        if(str_contains($arquivo->getClientOriginalExtension(),'pdf'))
        {
            $mime ="application/pdf";
        }
        else
        {
            $mime='image/'.$arquivo->getClientOriginalExtension();
        }
        $fileName = md5(time());
        //---move file-----
        $arquivo->move(public_path('upload').'/', $fileName.'.'.$arquivo->getClientOriginalExtension());

        $nomeArquivo = $arquivo->getClientOriginalName();

        //array('upload'=> new CURLFILE('teste.pdf'),'name' => 'teste.pdf','uploadManifest' => '{"input": {"description": "Descrição do arquivo", "entities_id": 0, "users_id": 300, "mime": "application/pdf"}}'),
        $data = array(
                       'upload'=> new \CURLFILE(public_path('upload').'/'. $fileName.'.'.$arquivo->getClientOriginalExtension()  ),
                       'name' => $fileName.'.'.$arquivo->getClientOriginalExtension() ,
                       'uploadManifest'=> json_encode([
                                                "input"=>[
                                                    "description" => "arquivo chamado",
                                                    "entities_id"=> 0,
                                                    "users_id" => addslashes(@Auth::user()->glpi_id),
                                                    "mime"=> "'.($mime).'",
                                                ]
                                        ]),
                    );

        $curl = curl_init();

        curl_setopt_array($curl, array(
          CURLOPT_URL => 'https://lcdesk.lowcost.com.br/apirest.php/Document/',
          CURLOPT_RETURNTRANSFER => true,
          CURLOPT_SSL_VERIFYPEER=> false,
          CURLOPT_ENCODING => '',
          CURLOPT_MAXREDIRS => 10,
          CURLOPT_TIMEOUT => 0,
          CURLOPT_FOLLOWLOCATION => true,
          CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
          CURLOPT_CUSTOMREQUEST => 'POST',
          CURLOPT_POSTFIELDS => $data,
          CURLOPT_HTTPHEADER => array(
            'app-token: '.$app_token,
            'session-token:'.$session_token,
          ),
        ));
         
        $response = curl_exec($curl);
        curl_close($curl);
        $json = json_decode($response,true);
        return $json['id'];
       
    }

  
}
