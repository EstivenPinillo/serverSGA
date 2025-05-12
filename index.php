<?php

require_once "Route/Route.php";
require_once "Route/Api.php";


Route::registerRoutes(
    Api::$route,
);

header("Access-Control-Allow-Origin: *"); 
header("Access-Control-Allow-Methods: POST, GET, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");
header("Content-Type: application/json; charset=utf-8");

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit();
}

$response = Route::passRequestToController();
echo json_encode($response);
