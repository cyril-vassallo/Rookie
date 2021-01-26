<?php

use Rookie\Kernel\Router;
use Rookie\Kernel\Configuration;

require_once "./../Rookie/Kernel/Configuration.php";
require_once "./../vendor/autoload.php";


//Find and load .env constants
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__.'/../');
$dotenv->load();

//Start the session
session_start();
$_SESSION['JSON'] = false;

$PATH = Configuration::getPaths();

require $PATH['PATH_ROOT'].$PATH["PATH_KERNEL"].'Router.php';
$router = new Router($PATH);

// require and instantiate the requested controller
require $router->getControllerPath(); 
$ControllerName = $router->getControllerName();
$app = new $ControllerName(); 

//destroy the app object
unset($app);


?>