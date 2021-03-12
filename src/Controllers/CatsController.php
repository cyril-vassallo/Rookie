<?php

namespace App\Controllers;

use App\Services\CatsServices;
use Rookie\Legacy\Controller;

/**
 * @Controller
 * @Route: 'cats'
 */
class CatsController extends Controller
{
    private $catsServices;

    public function __construct()
    {
        parent::__construct();
        $this->catsServices = new CatsServices();
        /* parent method */
        $this->setControllerResponse($this->CatsController());
    }

    public function __destruct()
    {
        unset($this->catsServices);
        parent::__destruct();
    }

    /**
     * Control the action server for the cats route
     * @return void
     **/
    public function CatsController(): string
    {
        $hasPayload = $this->request->hasPayload();
        $method = $this->request->method;
        $hasJson =  $this->request->json;
        $httpContent = '';
 

        if (!$hasJson) {
            echo 'NoJSON->';
            if ($method === 'VIEW') {
                echo 'VIEW';
                $httpContent = $this->initialView();
            }
        } else if ($hasJson && $hasPayload) {
            echo 'JSON & PAYLOAD->';
            if ($method === 'GET') {
                echo 'GET';
                $httpContent = $this->getCat();
            } else if ($method === 'POST') {
                echo 'POST';
                $httpContent = $this->postCat();
            } else if ($method === 'DELETE') {
                echo 'DELETE';
                $httpContent = $this->deleteCat();
            } else if ($method === 'PUT') {
                echo 'PUT';
                $httpContent = $this->putCat();
            }
        } else {
            echo 'ERROR';
            $this->hasError;
        }
        return $httpContent;
    }

    /**
     * Display a cats Collection
     * @method: 'VIEW'
     * @Response: 'Content-Type: text/html'
     */
    public function initialView(): string
    {
        $this->catsServices->selectCats();
        $cats = $this->catsServices->getQueryResults();
        return $this->response->create(["cats" => $cats], 200, "cats/cats.html.twig");
    }

    /**
     * One Cat
     * @method: 'GET'
     * @Response: 'Content-Type: application/json'
     */
    public function getCat(): string
    {
        $this->catsServices->selectCat($this->request->payload);
        $cat = $this->catsServices->getQueryResults();
        return $this->response->create($cat, 200);
    }

    /**
     * One Cat
     * @method: 'POST'
     * @Response: 'Content-Type: application/json'
     */
    public function postCat(): string
    {
        $this->catsServices->insertCat($this->request->payload);
        $cat = $this->catsServices->getQueryResults();
        return $this->response->create($cat, 200);
    }

    /**
     * One Cat
     * @method: 'DELETE'
     * @Response: 'Content-Type: application/json'
     */
    public function deleteCat(): string
    {
        $this->catsServices->deleteCat($this->request->payload);
        $cat = $this->catsServices->getQueryResults();
        return $this->response->create($cat, 200);
    }

    /**
     * One Cat
     * @method: 'PUT'
     * @Response: 'Content-Type: application/json'
     */
    public function putCat(): string
    {
        $this->catsServices->updateCat($this->request->payload);
        $cat = $this->catsServices->getQueryResults();
        return $this->response->create($cat, 200);
    }

}
