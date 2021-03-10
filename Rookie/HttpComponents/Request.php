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
        $this->setPostPayload();
        $this->setGetQuery();
        $this->isRouteParamExist();
        $this->isJsonParamExist();
        $this->isMethodParamExist();
    }

    private function setPostPayload()
    {
        foreach ($_POST as $key => $val) {
            $this->payload[$key] = htmlspecialchars($val, ENT_QUOTES);
        }
    }

    private function setGetQuery()
    {
        foreach ($_GET as $key => $val) {
            $this->query[$key] = htmlspecialchars($val, ENT_QUOTES);
        }
    }

    private function isRouteParamExist()
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

    private function isJsonParamExist()
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

    private function isMethodParamExist()
    {
        $this->method = 'VIEW';
        if (isset($this->payload["method"])) {
            $this->method = strtoupper($this->payload['method']);
        } else if (isset($this->query["method"])) {
            $this->method = strtoupper($this->query['method']);
        } else {
            $this->method = 'VIEW';
        }
    }

}
