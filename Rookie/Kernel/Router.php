<?php
namespace Rookie\Kernel;

/**
 * @author Cyril VASSALLO
 * Manage routes and requested Controller
 */
class Router
{
    private $defaultRoute;
    private $errorRoute;
    private $hasErrorRoute;
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
        $this->parseRoutesFile();
        $this->catchRouteFromHttpRequest();
        //$this->checkAuthorizedUsers();
        $this->isControllerExist();
    }

    /**
     * Return errorRoute
     */
    public function getErrorRoute(): string
    {
        return $this->errorRoute;
    }

    /**
     * Return hasErrorRoute state
     */
    public function getHasErrorRoute(): string
    {
        return $this->hasErrorRoute;
    }

    /**
     * Return the current controller name
     */
    public function getControllerName(): string
    {
        return $this->controller;
    }

    /**
     * Return the required controller instance
     */
    public function getControllerInstance(): object
    {
        $namespace = '\App\\Controllers\\';
        $newControllerInstance = $namespace . $this->getControllerName();
        return new $newControllerInstance();
    }

    /**
     * Parse route.ini file and assign values to attributes
     */
    private function parseRoutesFile(): void
    {
        $routesIniFile = $_ENV["ROOT"] . $_ENV["CONF"] . 'routes.ini';
        if (is_file($routesIniFile)) {
            $parsedRoutesFile = parse_ini_file($routesIniFile, false);
            $this->routes = $parsedRoutesFile['ROUTE'];
            $this->defaultRoute = $parsedRoutesFile['DEFAULT_ROUTE'];
            $this->hasErrorRoute = isset($parsedRoutesFile['ERROR_ROUTE']);
            if ($this->hasErrorRoute) {
                $this->errorRoute = $parsedRoutesFile['ERROR_ROUTE'];
            }
        }
    }

    /**
     * Provide a défault route it is not provided in url by the route parameter
     */
    private function catchRouteFromHttpRequest(): void
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
     */
    private function checkAuthorizedUsers(): void
    {
        if (!isset($_SESSION["user"]) || (isset($_SESSION["user"]) && $_SESSION["user"] = "")) {
            if (!in_array($this->currentRoute, $this->routes)) {
                $this->currentRoute = $this->defaultRoute;
            }
        }
    }

    /**
     * verify is route controller exist if not it provide a default controller
     */
    private function isControllerExist(): void
    {
        $this->controller = ucfirst($this->currentRoute . 'Controller');
        if (!(file_exists($_ENV["ROOT"] . $_ENV["CONTROLLER"] . $this->controller . ".php"))) {
            $this->hasErrorRoute ?
            $this->controller = ucfirst($this->errorRoute . 'Controller') :
            $this->controller = ucfirst($this->defaultRoute . 'Controller');
        }
    }

}
