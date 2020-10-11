<?php 
// header("Content-Type: application/json; charset=UTF_8");

header("Content-Type: application/json");
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
header('Access-Control-Allow-Headers: *');
// header('Access-Control-Expose-Headers: Access-Token, Uid');
// header("Access-Control-Max-Age: 3600");
// header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
// 

require_once realpath("vendor/autoload.php");
// require "vendor/autoload.php";
use \Firebase\JWT\JWT;

session_start();
$router = new MyApp\Controller\Router();
$router->run();
?>
