<?php

namespace App\Controllers;

use Exception;
use Rookie\Legacy\Controller;

/**
 * @Controller
 * @Route: 'movies'
 */
class HomeController extends Controller
{

    private $moviesService;

    public function __construct()
    {
        parent::__construct();
        $this->HomeController($this->request->method, $this->request->json);
    

    }

    public function __destruct()
    {
        parent::__destruct();
    }

    /**
     * Control the action server according to different methods for the home route
     *
     * @param string $method
     * @return void
     */
    private function HomeController(string $method, bool $json)
    {
        if (!$json) {
            $this->InitialView();
        }
    }

    /**
     * Read a movies Collection
     * @Query: 'GET'
     * @method: 'VIEW'
     * @Response: 'Content-Type: text/Html'
     */
    private function InitialView()
    {
        $controllerData = [
            'title' => 'Hey Rookie, Welcome !',
            'welcome' => 'I\'m the from scratch framework for PHP Rookie developer !',
            'thisController' => 'HomeController',
            'nextController' => 'MoviesController',
            'route' => 'movies',
        ];
        $this->VIEW('home/home.html.twig', $controllerData, 200);
    
       
    }

}
