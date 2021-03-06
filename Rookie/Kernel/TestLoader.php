<?php
//------------------------------------------------------
//--------------------TEST RUNTIME----------------------
//------------------------------------------------------

use Dotenv\Dotenv;
use Rookie\Kernel\Router;

require_once __DIR__."/../../vendor/autoload.php";

//Find and load .env constants
$dotenv = Dotenv::createImmutable(__DIR__.'/../../');
$dotenv->load();
$_ENV['ROOT'] = __DIR__.'/../../';

//Autoload classes
spl_autoload_register('Rookie\Kernel\Loader::classLoader');

?>