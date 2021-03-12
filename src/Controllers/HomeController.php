<?php

namespace App\Controllers;

use Rookie\Legacy\Controller;

/**
 * @Controller
 * @Route: 'home'
 */
class HomeController extends Controller
{

    public function __construct()
    {
        parent::__construct();
        /* parent method */
        $this->setControllerResponse($this->HomeController());
    }

    public function __destruct()
    {
        parent::__destruct();
    }

    /**
     * Control the action server according to different methods for the home route
     */
    public function HomeController(): string
    {
        $htmlContent = '';
        if ($this->request->method === 'VIEW') {
            $htmlContent  = $this->InitialView();
        }else {
            /* parent property */
            $this->hasError = true;
        }
        return $htmlContent;
    }

    /**
     * Read a movies Collection
     * @method: 'VIEW'
     * @Response: 'Content-Type: text/Html'
     */
    public function InitialView()
    {
        $controllerData = [
            'title' => 'Hey Rookie, Welcome !',
            'welcome' => 'I\'m the from scratch framework for PHP Rookie developer !',
            'thisController' => 'HomeController',
            'nextController' => 'MoviesController',
            'route' => 'movies',
        ];
        return $this->response->create($controllerData, 200, 'home/home.html.twig', );

    }

}
