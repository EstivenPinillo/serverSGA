<?php

require_once("Controller/Curl.php");

class QuoteController {

    public function offer() {

        $url = "http://aseguradoraficticia.com:50/api/cotizar/";

        $input = json_decode(file_get_contents('php://input'), true);

        if (!$input) {
            http_response_code(400);
            exit;
        }
        
        $name = $input["name"];
        $lastName = $input["last_name"];
        $dateBirth = $input["date_birth"];
        $licensePlate = $input["license_plate"];

        $data = [
            "name" => $name,
            "date_birth" => $dateBirth, 
            "license_plate" => $licensePlate,
            "last_name" => $lastName
        ];

        $dataJSON = json_encode($data);

        $curl = new Curl();
        $response = $curl->post($url,$dataJSON);
        
        return $response;
    }


}