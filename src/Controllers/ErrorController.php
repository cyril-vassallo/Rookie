<?php

namespace App\Controllers;

use Rookie\Legacy\Controller;

/**
 * @Controller
 * @Route: 'error'
 */
class ErrorController extends Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->response = $this->ErrorController();
    }

    public function __destruct()
    {
        parent::__destruct();
    }

    /**
     * Control the action server for the error route
     *
     * @return void
     **/
    private function ErrorController()
    {
        $code = "404";
        $message = 'This page dosn\'t exist';
        return $this->VIEW('error/error.html.twig', ['message' => $message, 'code' => $code], 404);
    }

}
