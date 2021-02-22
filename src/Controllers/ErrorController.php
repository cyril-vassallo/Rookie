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
        $this->ErrorController();
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
        $this->errorView();
    }

    /**
     * Display error page
     * @method: 'Default'
     * @Response: 'Content-Type: text/html'
     */
    private function errorView()
    {
        $code = "404";
        $message = 'This page dosn\'t exist';
        $this->VIEW('error/error.html.twig', ['message' => $message, 'code' => $code], 404);
    }


}
