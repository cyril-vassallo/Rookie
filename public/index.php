<?php
require_once "./../vendor/autoload.php";

use Rookie\Kernel\Loader;

$loader = new Loader();
$loader->rookie();
unset($loader);

?>