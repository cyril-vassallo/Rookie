<?php
//Do not remove this class it display 404 page on route error
//If remove be sure to update manually the  file Rookie\Kernel\Loader.php line 46

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
        $this->setControllerResponse($this->ErrorController());
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
        return $this->response->create(['message' => $message, 'code' => $code], 404, 'error/error.html.twig');
    }

}
