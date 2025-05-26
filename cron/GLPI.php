<?php

    include_once 'conf.php';

    function doGLPI_login($username,$password)
    {
        $baseURL = "https://lcdesk.lowcost.com.br/apirest.php";

        $app_token = GLPI_TOKEN;

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