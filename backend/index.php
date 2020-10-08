<?php 
// header("Content-Type: application/json; charset=UTF_8");

header("Content-Type: application/json");
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST');
header('Access-Control-Allow-Headers: *');
// 

require_once realpath("vendor/autoload.php");
// require "vendor/autoload.php";

session_start();
$router = new MyApp\Controller\Router();
$router->run();
?>
