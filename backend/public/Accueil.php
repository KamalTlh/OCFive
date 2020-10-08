<?php
// require 'config/Datadb.php';
// require 'config/Autoloader.php';
require 'vendor/autoload.php';
// use 'vendor\autoload.php';

// use config\Autoloader;
// Autoloader::register();
// session_start();
$router = new \controller\Router();
$router->run();
