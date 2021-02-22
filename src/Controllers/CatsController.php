<?php

namespace App\Controllers;

use App\Services\CatsServices;
use Rookie\Legacy\Controller;
use Rookie\Kernel\ErrorException;

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
        $this->CatsController(
            $this->request->method, 
            $this->request->json, 
            $this->request->query ,
            $this->request->payload
        );
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
    private function CatsController(string $method, bool $json, array $query, array $payload)
    {
        if (!$json && $query != []) {
            $this->initialView();
        } else {
            //has json
            if ($method === 'GET' && $payload != []) {
                $this->getCat($payload);
            } else if ($method === 'POST' && $payload != []) {
                $this->postCat($payload);
            } else if ($method === 'DELETE' && $payload != []) {
                $this->deleteCat($payload);
            } else if ($method === 'PUT' && $payload != []) {
                $this->putCat($payload);
            } else {
                header('Location:error');
            }
        }
    }


   /**
    * Display a cats Collection
    * @method: 'VIEW'
    * @Response: 'Content-Type: text/html'
    */
    private function initialView()
    {
        $this->catsServices->selectCats();
        $this->VIEW("cats/cats.html.twig",[ "cats" => $this->catsServices->getQueryResults() ], 200);
    }
  
     /**
     * One Cat 
     * @method: 'GET'
     * @Response: 'Content-Type: application/json'
     */
     private function getCat(array $payload)
     {
        $this->catsServices->selectCat($payload);
        $this->JSON($this->catsServices->getQueryResults(),200);
     }
    
     /**
     * One Cat 
     * @Query: 'POST'
     * @method: 'POST'
     * @Response: 'Content-Type: application/json'
     */
     private function postCat(array $payload)
     {
        $this->catsServices->insertCat($payload);
        $this->JSON($this->catsServices->getQueryResults(),200);
     }
    
     /**
     * One Cat 
     * @Query: 'POST'
     * @method: 'DELETE'
     * @Response: 'Content-Type: application/json'
     */
     private function deleteCat(array $payload)
     {
        $this->catsServices->deleteCat($payload);
        $this->JSON($this->catsServices->getQueryResults(),200);
     }
    
     /**
     * One Cat 
     * @Query: 'POST'
     * @method: 'PUT'
     * @Response: 'Content-Type: application/json'
     */
     private function putCat(array $payload)
     {
        $this->catsServices->updateCat($payload);
        $this->JSON($this->catsServices->getQueryResults(),200);
     }
    
  
    
}
