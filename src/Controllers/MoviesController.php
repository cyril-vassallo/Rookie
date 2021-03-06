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
        $this->MoviesController($this->request->method, $this->request->JSON);
    }

    public function __destruct()
    {
        parent::__destruct();
        unset($this->moviesService);
    }

    /**
     * Control the action server according to different methods for the movies route
     *
     * @param string $method
     * @return void
     */
    private function MoviesController(string $method, bool $JSON)
    {
        if (!$JSON && $method === 'VIEW') {
            $this->InitialView($this->request->payload);
        } else if ($JSON && $method === 'DELETE') {
            $this->DeleteMovie($this->request->payload);
        } else if ($JSON && $method === 'POST') {
            $this->PostMovie($this->request->payload);
        } else if ($JSON && $method === 'PUT') {
            $this->PutMovie($this->request->payload);
        } else if ($JSON && $method === 'GET') {
            $this->GetMovie($this->request->payload);
        }
    }

    /**
     * Read a movies Collection
     * @Query: 'GET'
     * @method: 'VIEW'
     * @Response: 'Content-Type: text/plain'
     */
    private function InitialView(array $payload)
    {
        $this->moviesService->selectMovies($payload);
        $movies = $this->moviesService->getQueryResults();
        echo $this->twig->render('movies/movies.html.twig', ['movies' => $movies]);
    }

    /**
     * Delete one Movie
     * @Query: 'POST'
     * @method: 'DELETE'
     * @Response: 'Content-Type: application/json'
     */
    private function DeleteMovie(array $payload)
    {
        $this->moviesService->deleteMovie($payload);
        $this->JSON($this->moviesService->getQueryResults(), 200);
    }

    /**
     * Create one Movie
     * @Query: 'POST'
     * @method: 'POST'
     * @Response: 'Content-Type: application/json'
     */
    private function PostMovie(array $payload)
    {
        $this->moviesService->insertMovie($payload);
        $this->JSON($this->moviesService->getQueryResults(), 200);
    }

    /**
     * Update one Movie
     * @Query: 'POST'
     * @method: 'PUT'
     * @Response: 'Content-Type: application/json'
     */
    private function PutMovie(array $payload)
    {
        $this->moviesService->updateMovie($payload);
        $this->JSON($this->moviesService->getQueryResults(), 200);

    }

    /**
     * Read one Movie
     * @Query: 'POST'
     * @method: 'GET'
     * @Response: 'Content-Type: application/json'
     */
    private function GetMovie(array $payload)
    {
        $this->moviesService->selectMovie($payload);
        $this->JSON($this->moviesService->getQueryResults(), 200);

    }

}
