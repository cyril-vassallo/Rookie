<?php

namespace Rookie\Kernel;

use Exception;

class ErrorException
{

    private $home;

    public function __construct(string $message = "Sorry, something happened on server side !")
    {
        $explodePath = explode("/", $_SERVER["SCRIPT_NAME"]);

        for ($i = 1; $i < count($explodePath) - 2; $i++) {
            $this->home;
            $this->home .= '/' . $explodePath[$i];
        }
        throw new Exception(
            "<p style='color:black; border:1px dotted black; text-align: center; padding:5px'>"
            . $message . " Please go back to the home page <a href='" . $this->home . "'>here</a>
        </p>");
    }

}
