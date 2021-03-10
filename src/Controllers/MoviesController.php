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
        $this->response = $this->MoviesController(
            $this->request->method,
            $this->request->json,
            $this->request->query,
            $this->request->payload
        );
    }

    public function __destruct()
    {
        unset($this->moviesService);
        parent::__destruct();
    }

    /**
     * Control the action server for the movies route
     *
     * @param string $method
     * @return void
     */
    private function MoviesController(string $method, bool $json, array $query, array $payload)
    {
        $httpContent = "";
        if ($method === 'VIEW' && !$json && $query != []) {
            $httpContent = $this->initialView();
        } else if ($method === 'DELETE' && $json && $payload != []) {
            $httpContent = $this->deleteMovie($payload);
        } else if ($method === 'POST' && $json && $payload != []) {
            $httpContent = $this->postMovie($payload);
        } else if ($method === 'PUT' && $json && $payload != []) {
            $httpContent = $this->putMovie($payload);
        } else if ($method === 'GET' && $json && $payload != []) {
            $httpContent = $this->getMovie($payload);
        } else {
            $this->hasError = true;
        }

        return $httpContent;
    }

    /**
     * Display a movies Collection
     * @Query: 'GET'
     * @method: 'VIEW'
     * @Response: 'Content-Type: text/html'
     */
    private function initialView()
    {
        $this->moviesService->selectMovies();
        $movies = $this->moviesService->getQueryResults();
        return $this->VIEW('movies/movies.html.twig', ['movies' => $movies], 200);
    }

    /**
     * Delete one Movie
     * @Query: 'POST'
     * @method: 'DELETE'
     * @Response: 'Content-Type: application/json'
     */
    private function deleteMovie(array $payload)
    {
        $this->moviesService->deleteMovie($payload);
        return $this->JSON($this->moviesService->getQueryResults(), 200);
    }

    /**
     * Create one Movie
     * @Query: 'POST'
     * @method: 'POST'
     * @Response: 'Content-Type: application/json'
     */
    private function postMovie(array $payload)
    {
        $this->moviesService->insertMovie($payload);
        return $this->JSON($this->moviesService->getQueryResults(), 200);
    }

    /**
     * Update one Movie
     * @Query: 'POST'
     * @method: 'PUT'
     * @Response: 'Content-Type: application/json'
     */
    private function putMovie(array $payload)
    {
        $this->moviesService->updateMovie($payload);
        return $this->JSON($this->moviesService->getQueryResults(), 200);
    }

    /**
     * Read one Movie
     * @Query: 'POST'
     * @method: 'GET'
     * @Response: 'Content-Type: application/json'
     */
    private function getMovie(array $payload)
    {
        $this->moviesService->selectMovie($payload);
        return $this->JSON($this->moviesService->getQueryResults(), 200);
    }

}
