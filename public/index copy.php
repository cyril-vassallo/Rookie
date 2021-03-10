<?php
//------------------------------------------------------
//-------INDEX.PHP IS THE GLOBAL RUNTIME CONTEXT--------
//------------------------------------------------------

use Dotenv\Dotenv;
use Rookie\Kernel\Router;

//require_once "./../Rookie/Kernel/Loader.php";
require_once "./../vendor/autoload.php";

//Find and load .env constants
$DOCUMENT_ROOT = getcwd();
$dotenv = Dotenv::createImmutable($DOCUMENT_ROOT.'/../');
$dotenv->load();
$_ENV['ROOT'] = $DOCUMENT_ROOT.'/../';
//Start the session
session_start();
//Autoload classes
// spl_autoload_register('Rookie\Kernel\Loader::classes');
//Route the application
$router = new Router();
//Execute the required Controller
try
{
    $app = $router->getControllerInstance();
}
catch(Exception $e)
{ 
    echo $e;
}
//Destroy the app object
unset($app);

?>