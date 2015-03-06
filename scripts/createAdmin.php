<?php

$user = $argv[1];
$pass = $argv[2];
$email = $argv[3];

error_reporting(E_ALL);
ini_set("display_errors", 1);

define("APP_ROOT", __DIR__ . "/..");
require_once __DIR__ . "/../Classes/Autoloader.php";

$config = new \Config("config");
$db = new \Database($config->database);

Registry::add("config", $config);
Registry::add("db", $db);

$admin = new \Model\Admin();
$admin->username = $user;
$admin->password = md5($pass);
$admin->email = $email;
$admin->write();