<?php

class Curl {

    public function post($url, $dataInJSON) {

        $curl = curl_init($url);
       
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $dataInJSON);
        curl_setopt($curl, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        
        $response = curl_exec($curl);
        curl_close($curl);
        
        return json_decode($response);
    }

    public function get($url, $dataInJSON) {

        $curl = curl_init($url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    
        $response = curl_exec($curl);
        curl_close($curl);
        
        return $response;
    }


}