<?php
error_reporting(E_ALL);
ini_set("display_errors", 1);
xdebug_disable();

session_start();

define("APP_ROOT", __DIR__ . "/..");
$_ENV = array_merge($_ENV, parse_ini_file(APP_ROOT . "/.env", true));
try{
    require_once __DIR__ . "/../Classes/Autoloader.php";

    $config = new \Config("config");
    $db = new \Database($_ENV['database']);

    Registry::add("config", $config);
    Registry::add("db", $db);

    $request = new Request($_REQUEST);
    
    $response = new Response(new Output\View("main"));

    $callable = Router::route($request);
    call_user_func($callable, $request, $response);

    echo $response->present();
}catch(Exception $ex){
    $response = new Response(new Output\View("main"));
    $response->json(array("message" => $ex->getMessage(), "trace" => $ex->getTrace()), 500);
    echo $response->present();
}