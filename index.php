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

$response = Route::passRequestToController();
echo json_encode($response);
