<?php
namespace Rookie\HttpComponents;

/**
 * @author Cyril VASSALLO
 * Filter and secure variables from http requests
 * Variables can be used in all layers with the Request Object
 */
class Request
{
    public $method;
    public $json;
    public $query;
    public $payload;

    public function __construct()
    {
        $this->query = [];
        $this->payload = [];
        $this->method = 'VIEW';
        $this->json = false;
        $this->setPayload();
        $this->setQuery();
        $this->setRoute();
        $this->setJson();
        $this->setMethod();
    }

    /**
     * set payload property
     *
     * @return void
     */
    public function setPayload(): void
    {
        foreach ($_POST as $key => $val) {
            $this->payload[$key] = htmlspecialchars($val, ENT_QUOTES);
        }
    }

    /**
     * set query property
     *
     * @return void
     */
    public function setQuery(): void
    {
        foreach ($_GET as $key => $val) {
            $this->query[$key] = htmlspecialchars($val, ENT_QUOTES);
        }
    }

    /**
     * set route property
     *
     * @return void
     */
    public function setRoute(): void
    {$hasNoPayloadRoute = !isset($this->payload["route"]) || $this->payload["route"] == '';
        $hasNoQueryRoute = !isset($this->query["route"]) || $this->query["route"] == '';
        if ($hasNoPayloadRoute && $hasNoQueryRoute) {
            $routesIniFile = $_ENV["ROOT"] . $_ENV["CONF"] . 'routes.ini';
            if (is_file($routesIniFile)) {
                $parsedRoutesFile = parse_ini_file($routesIniFile, false);
                $this->payload["route"] = $parsedRoutesFile['DEFAULT_ROUTE'];
            }
        }
    }

    /**
     * set Json property
     *
     * @return void
     */
    public function setJson(): void
    {
        if (!(isset($this->payload["format"])) || $this->payload["format"] == "html") {
            $this->json = false;
            if (!(isset($this->query["format"])) || $this->query["format"] == 'html') {
                $this->json = false;
            } else {
                $this->json = true;
            }
        } else {
            $this->json = true;
        }
    }

    /**
     * set Method property
     *
     * @return void
     */
    public function setMethod(): void
    {   
      
        //Case 1 Payload has method     
        //      - hasJSON     
        //Case 2 query has method
        //       - hasJSON
        //case 3 no method detected
        //      - hasJSON
        //Case 4 

        $hasOptions = $this->hasOptions();
        $this->method = 'VIEW';
         
        if (isset($this->payload["method"])) {
            $this->method = strtoupper($this->payload['method']);
        } 
        else if (isset($this->query["method"])) {
            $this->method = strtoupper($this->query['method']);
        }
        else if (!isset($this->query["method"]) && !isset($this->payload['method'])) {
            $this->method = "VIEW";
        } 
    }

    /**
     * Check if payload is empty or not
     *
     * @return boolean
     */
    public function hasPayload(): bool
    {
        return $this->payload !== [] ? true : false;
    }

    /**
     * Check if query string is empty or not
     *
     * @return boolean
     */
    public function hasQueryString(): bool
    {
        $copyQuery = $this->query;
        unset($copyQuery["route"]);
        return $copyQuery !== [] ? true : false;
    }

    /**
     * Check if options exist in query String
     *
     * @return boolean
     */
    public function hasOptions(): bool
    {
        $hasOptions = isset($this->query["option1"])
            ||
            (isset($this->query["option1"]) && isset($this->query["option2"]))
            ||
            (isset($this->query["option1"]) && isset($this->query["option2"]) && isset($this->query["option3"]));
        return $hasOptions;
    }
}
