<?php
//------------------------------------------------------
//-------INDEX.PHP IS THE GLOBAL RUNTIME CONTEXT--------
//------------------------------------------------------

use Rookie\Kernel\Router;

require_once "./../Rookie/Kernel/Loader.php";
require_once "./../vendor/autoload.php";

//Find and load .env constants
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__.'/../');
$dotenv->load();
$_ENV['ROOT'] = __DIR__.'/../';
//Start the session
session_start();
//Autoload classes
spl_autoload_register('Rookie\Kernel\Loader::classLoader');
//Route the application
$router = new Router();
//Execute the required Controller
$app = $router->getControllerInstance();
//Destroy the app object
unset($app);

?>