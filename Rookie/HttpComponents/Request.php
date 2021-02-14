<?php
namespace Rookie\HttpComponents;

use Rookie\Kernel\Loader;

/**
 * @author Cyril VASSALLO
 * Filter and secure variables from http requests
 * Variables can be used in all layers with the Request Object
 */
class Request
{

    private $PATH;
    public $method;
    public $JSON;
    public $query;
    public $payload;

    public function __construct()
    {
        $this->PATH = Loader::pathsLoader();
        $this->query = [];
        $this->payload = [];
        $this->JSON = true;
        $this->method = 'VIEW';
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
    {
        if ((!isset($this->payload["route"])) || $this->payload["route"] == '') {
            $routesIniFile = $_ENV["ROOT"] . $this->PATH["CONF"] . 'routes.ini';
            if (is_file($routesIniFile)) {
                $parsedRoutesFile = parse_ini_file($routesIniFile, false);
                $this->payload["route"] = $parsedRoutesFile['DEFAULT_ROUTE'];
            }
        }
    }

    private function isJsonParamExist()
    {
        if (!(isset($this->payload["JSON"])) || $this->payload["JSON"] == false) {
            $this->JSON = false;
        } else {
            $this->JSON = true;
        }
    }

    private function isMethodParamExist()
    {
        if (!(isset($this->payload["method"])) || $this->payload["method"] == '') {
            $this->method = strtoupper($this->payload["method"] = 'VIEW');
        } else {
            $this->method = $this->payload['method'];
        }
    }

}
