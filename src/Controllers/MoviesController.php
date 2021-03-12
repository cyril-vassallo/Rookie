<?php

namespace App\Controllers;

use App\Services\MoviesServices;
use Rookie\Legacy\Controller;

/**
 * @Controller
 * @Route: 'movies'
 */
class MoviesController extends Controller
{

    private $moviesService;

    public function __construct()
    {
        parent::__construct();
        $this->moviesService = new MoviesServices();
        /* parent method */
        $this->setControllerResponse($this->MoviesController());
    }

    public function __destruct()
    {
        unset($this->moviesService);
        parent::__destruct();
    }

       /**
     * Control the action server for the movies route
     * @return void
     **/
    public function MoviesController(): string
    {
        $hasPayload = $this->request->hasPayload();
        $method = $this->request->method;
        $hasJson =  $this->request->json;
        $httpContent = '';
 

        if (!$hasJson) {
            if ($method === 'VIEW') {
                $httpContent = $this->initialView();
            }
        } else if ($hasJson && $hasPayload) {
            if ($method === 'GET') {
                $httpContent = $this->getMovie();
            } else if ($method === 'POST') {
                $httpContent = $this->postMovie();
            } else if ($method === 'DELETE') {
                $httpContent = $this->deleteMovie();
            } else if ($method === 'PUT') {
                $httpContent = $this->putMovie();
            }
        } else {
            $this->hasError;
        }
        return $httpContent;
    }

    /**
     * Display a movies Collection
     * @method: 'VIEW'
     * @Response: 'Content-Type: text/html'
     */
    public function initialView(): string
    {
        $this->moviesService->selectMovies();
        $movies = $this->moviesService->getQueryResults();
        return $this->response->create(['movies' => $movies], 200, 'movies/movies.html.twig');
    }

    /**
     * Delete one Movie
     * @method: 'DELETE'
     * @Response: 'Content-Type: application/json'
     */
    public function deleteMovie(): string
    {
        $this->moviesService->deleteMovie($this->request->payload);
        return $this->response->create($this->moviesService->getQueryResults(), 200);
    }

    /**
     * Create one Movie
     * @method: 'POST'
     * @Response: 'Content-Type: application/json'
     */
    public function postMovie(): string
    {
        $this->moviesService->insertMovie($this->request->payload);
        return $this->response->create($this->moviesService->getQueryResults(), 200);
    }

    /**
     * Update one Movie
     * @method: 'PUT'
     * @Response: 'Content-Type: application/json'
     */
    public function putMovie(): string
    {
        $this->moviesService->updateMovie($this->request->payload);
        return $this->response->create($this->moviesService->getQueryResults(), 200);
    }

    /**
     * Read one Movie
     * @method: 'GET'
     * @Response: 'Content-Type: application/json'
     */
    public function getMovie(): string
    {
        $this->moviesService->selectMovie($this->request->payload);
        return $this->response->create($this->moviesService->getQueryResults(), 200);
    }

}
