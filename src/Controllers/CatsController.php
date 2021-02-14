<?php

namespace App\Controllers;

use Rookie\Legacy\Controller;

/**
 * @Controller
 * @Route: 'cats'
 */
class CatsController extends Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->CatsController($this->request->method, $this->request->JSON);
    }

    public function __destruct()
    {
        parent::__destruct();
    }

    /**
     * Control the action server according to different methods for the Cats route
     *
     * @return void
     **/
    private function CatsController(string $method, bool $JSON)
    {
        if (!$JSON && $method === 'VIEW') {
            $this->InitialView($this->request->payload);
        } else if ($JSON && $method === 'GET') {
            $this->GetCat($this->request->payload);
        } else if ($JSON && $method === 'POST') {
            $this->PostCat($this->request->payload);
        } else if ($JSON && $method === 'DELETE') {
            $this->DeleteCat($this->request->payload);
        } else if ($JSON && $method === 'PUT') {
            $this->PutCat($this->request->payload);
        }
    }

    //you can use rookie-controller-view and rookie-controller-CRUD snippets now

    /**
     * Display a cats Collection
     * @Query: 'GET'
     * @method: 'VIEW'
     * @Response: 'Content-Type: text/plain'
     */
    private function InitialView(array $payload)
    {
        $cats = [];
        //Code here service access logic to get data...
        echo $this->twig->render('cats/cats.html.twig', ['cats' => $cats]);
    }

    /**
     * One Cat
     * @Query: 'POST'
     * @method: 'GET'
     * @Response: 'Content-Type: application/json'
     */
    private function GetCat(array $payload)
    {
        $response;
        //Code here service access logic to GET data...
        $this->JSON($response, 200);
    }

    /**
     * One Cat
     * @Query: 'POST'
     * @method: 'POST'
     * @Response: 'Content-Type: application/json'
     */
    private function PostCat(array $payload)
    {
        $response;
        //Code here service access logic to Post data...
        $this->JSON($response, 200);
    }

    /**
     * One Cat
     * @Query: 'POST'
     * @method: 'DELETE'
     * @Response: 'Content-Type: application/json'
     */
    private function DeleteCat(array $payload)
    {
        $response;
        //Code here service access logic to delete data...
        $this->JSON($response, 200);
    }

    /**
     * One Cat
     * @Query: 'POST'
     * @method: 'PUT'
     * @Response: 'Content-Type: application/json'
     */
    private function PutCat(array $payload)
    {
        $response;
        //Code here service access logic to PUT data...
        $this->JSON($response, 200);
    }

}
