<?php
namespace Rookie\Kernel;

use Rookie\Kernel\Loader;
use App\Services\LogServices;

/**
 * @author Cyril VASSALLO
 * Manage routes and requested Controller
 */
class Router
{
    private $PATH;
    private $defaultRoute;
    private $errorRoute;
    private $controller;
    private $routes;
    private $currentRoute;

    /**
     * When instantiate router object it verify
     * if the requested route exist
     * if the requested controller exist
     * else provide a default route and controller
     */
    public function __construct()
    {
        $this->PATH = Loader::pathsLoader();
        $this->parseRoutesFile();
        $this->catchRouteFromHttpRequest();
        //$this->checkAuthorizedUsers();
        $this->isControllerExist();
        $this->parseRoutesFile();
    }

    /**
     * Return the current controller name
     *
     * @return [string]
     */
    public function getControllerName()
    {
        return $this->controller;
    }

    /**
     * Return the required controller instance
     *
     * @return void
     */
    public function getControllerInstance()
    {
        $path = '\App\\Controllers\\';
        $newControllerInstance = $path . $this->getControllerName();
        return new $newControllerInstance();
    }

    /**
     * Parse route.ini file and assign values to attributes
     *
     * @return void
     */
    private function parseRoutesFile()
    {
        $routesIniFile = $_ENV["ROOT"] . $this->PATH["CONF"] . 'routes.ini';
        if (is_file($routesIniFile)) {
            $parsedRoutesFile = parse_ini_file($routesIniFile, false);
            $this->routes = $parsedRoutesFile['ROUTE'];
            $this->defaultRoute = $parsedRoutesFile['DEFAULT_ROUTE'];
            $this->errorRoute = $parsedRoutesFile['ERROR_ROUTE'];
        }
    }

    /**
     * Provide a défault route it is not provided in url by the route parameter
     *
     * @return void
     */
    private function catchRouteFromHttpRequest()
    {
        if ((isset($_GET["route"])) && ($_GET["route"] != "")) {
            $this->currentRoute = $_GET["route"];
        } else {
            if ((isset($_POST["route"])) && ($_POST["route"] != "")) {
                $this->currentRoute = $_POST["route"];
            } else {
                $this->currentRoute = $this->defaultRoute;

            }
        }

    }

    /**
     * Verify if the requested route is authorized as public
     *
     * @return void
     */
    private function checkAuthorizedUsers()
    {
        if (!isset($_SESSION["user"]) || (isset($_SESSION["user"]) && $_SESSION["user"] = "")) {
            if (!in_array($this->currentRoute, $this->routes)) {
                $this->currentRoute = $this->defaultRoute;
            }
        }
    }

    /**
     * verify is route controller exist if not it provide a default controller
     *
     * @return void
     */
    private function isControllerExist()
    {
        $this->controller = ucfirst($this->currentRoute . 'Controller');
        if (!(file_exists($_ENV["ROOT"] . $this->PATH["CONTROLLER"] . $this->controller . ".php"))) {
            $this->controller = ucfirst($this->errorRoute . 'Controller');
        }
    }

}
