<?php

error_reporting(E_ALL);
ini_set("display_errors", 1);

define("APP_ROOT", __DIR__ . "/..");
require_once __DIR__ . "/../Classes/Autoloader.php";

$config = new \Config("config");
$db = new \Database($config->database);

Registry::add("config", $config);
Registry::add("db", $db);

$customerModel = new \Model\Customer();
foreach($customerModel->fetchAll() as $customer){
    
}