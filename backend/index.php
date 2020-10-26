<?php 

header("Content-Type: application/json");
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
header('Access-Control-Allow-Headers: *');

require_once realpath("vendor/autoload.php");
// require "vendor/autoload.php";
use \Firebase\JWT\JWT;

$router = new MyApp\Controller\Router();
$router->run();
?>
