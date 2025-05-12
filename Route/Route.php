<?php

abstract class Route {

public static array $route;

public static function getUrl(): string {

    $url = $_SERVER["REQUEST_URI"];
    return $url;
}

public static function getMethod(): string {

    $method = $_SERVER["REQUEST_METHOD"];
    return $method;
}

public static function getUrlData() {
    
    $urlData = explode("/",Route::getUrl());
    $urlData = array_filter($urlData, fn($v) => $v != "");

    return $urlData;
}

public static function validateUrl(): bool|array {

    $urlRequest = Route::getUrl();
    $methodRequet = Route::getMethod();

    $routeRequest = strtolower($urlRequest);
    
    $count = 0;
    str_replace('/',".",$routeRequest, $count);

    $urlData = Route::getUrlData();
    $quantity = count($urlData);

    $urlId =  $quantity >= 3 && $quantity > 2 ? $urlData[3] : "" ;

    if($count >= 3 && $quantity < 3 ) {
        $routeRequest = substr($routeRequest, 0, -1);
    }

    $validate = false;

    foreach (Route::$route as $controller => $method) {

        foreach ($method as $method => [ $url ,$function]) {
            
            $url = str_replace("{id}", $urlId, $url);

            if ($routeRequest == $url && $methodRequet == $method) {            
                return [$controller, $method, $function];
            } 
        }
    }

    return $validate;
}

public static function getController(string $controllerClass) {

    try {

        require_once("Controller/{$controllerClass}.php");
        $instanceController = new $controllerClass();

        return $instanceController;

    } catch (\Throwable $th) {

        header("HTTP/1.0 406 Not Acceptable | ".$th->getMessage());
    }
}

public static function registerRoutes(...$route) {

    Route::$route = array_merge(...$route);
}

public static function passRequestToController() {

    try {

        if (Route::validateUrl()) {

            $request = Route::validateUrl();
        
            $controllerClass = $request[0];
            $methodRequet = $request[1];
            $function = $request[2];

            $instanceClass = Route::getController($controllerClass);
            
            return $instanceClass->$function();

        }else {
            header("HTTP/1.0 503 Service Unavailable");
            echo "invalid ENDPOINT response: ";
        }

    } catch (\Throwable $th) {

        header("HTTP/1.0 503 Service Unavailable | ".$th->getMessage());
    }

    
    
}

}