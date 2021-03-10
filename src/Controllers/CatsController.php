<?php

namespace App\Controllers;

use App\Services\CatsServices;
use Rookie\DataComponents\LogMaker;
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
        $this->log = new LogMaker();
        $this->catsServices = new CatsServices();
        $this->setResponse($this->CatsController());
    }

    public function __destruct()
    {
        unset($this->catsServices);
        parent::__destruct();
    }

    /**
     * Control the action server for the cats route
     *
     * @return void
     **/
    public function CatsController()
    {
        $httpContent = '';
        if ($this->request->method === 'VIEW') {
            $httpContent = $this->initialView();
        } else if ($this->request->method === 'GET') {
            $httpContent = $this->getCat();
        } else if ($this->request->method === 'POST') {
            $httpContent = $this->postCat();
        } else if ($this->request->method === 'DELETE') {
            $httpContent = $this->deleteCat();
        } else if ($this->request->method === 'PUT') {
            $httpContent = $this->putCat();
        } else {
            $this->hasError = true;
        }
        return $httpContent;
    }

    /**
     * Display a cats Collection
     * @method: 'VIEW'
     * @Response: 'Content-Type: text/html'
     */
    private function initialView()
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
    private function getCat()
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
    private function postCat()
    {
        $this->catsServices->insertCat($this->request->payload);
        $cat = $this->catsServices->getQueryResults();
        return $this->JSON($cat, 200);
    }

    /**
     * One Cat
     * @method: 'DELETE'
     * @Response: 'Content-Type: application/json'
     */
    private function deleteCat()
    {
        $this->catsServices->deleteCat($this->request->payload);
        $cat = $this->catsServices->getQueryResults();
        return $this->JSON($cat, 200);
    }

    /**
     * One Cat
     * @method: 'PUT'
     * @Response: 'Content-Type: application/json'
     */
    private function putCat()
    {
        $this->catsServices->updateCat($this->request->payload);
        $cat = $this->catsServices->getQueryResults();
        return $this->JSON($cat, 200);
    }

}
