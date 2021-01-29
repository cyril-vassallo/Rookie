<?php

use Rookie\Kernel\Router;
use Rookie\Kernel\Loader;

require_once "./../Rookie/Kernel/Loader.php";
require_once "./../vendor/autoload.php";


//Find and load .env constants
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__.'/../');
$dotenv->load();
$_ENV['ROOT'] = __DIR__.'/../';

//Start the session
session_start();

$PATH = Loader::getPATHS();
require $_ENV['ROOT'].$PATH["KERNEL"].'Router.php';
$router = new Router($PATH);

// require and instantiate the requested controller
require $router->getControllerPath(); 
$ControllerName = $router->getControllerName();
$app = new $ControllerName(); 

//destroy the app object
unset($app);


?>