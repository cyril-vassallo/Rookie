<?php
namespace Rookie\Legacy;


use Rookie\HttpComponents\Request;
use Rookie\DataComponents\LogMaker;
use Rookie\HttpComponents\Response;

/**
 * @author Cyril VASSALLO
 * Init object in constructor and provide necessary methods for controllers
 */
class Controller
{

    protected $request;
    public $response;
    public $hasError;

    public function __construct()
    {
        $this->request = new Request();
        $this->response = new Response($this->request);
        $this->hasError = false;
    }

    public function __destruct()
    {
        unset($this->request);
        unset($this->response);
        unset($this->hasError);
    }

    public function setResponse(string $content):void{
        $this->response->content = $content;
    }

    public function getResponse(): string{
        return $this->response->content;
    }



}
