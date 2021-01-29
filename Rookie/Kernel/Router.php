<?php
namespace Rookie\Kernel;

/**
 * The Rooter Class 
 * Manage routes and requested Controller
 */
class Router
{
	private $PATH;
	private $defaultRoute;
	private $controller;
	private $routes;
	private $currentRoute;

	/**
	 * When instantiate router object it verify 
	 * if the requested route exist
	 * if the requested controller exist
	 * else provide a default route and controller
	 */
	public function __construct($PATH){
		$this->PATH = $PATH;
		$this->parseRoutesFile();
		$this->catchRouteFromHttpRequest();
		//$this->checkAuthorizedUsers();
		$this->isControllerExist();
		$this->parseRoutesFile();
	}
	


	/**
	 * Return the current controller path
	 *
	 * @return [string] 
	 */
	public function getControllerPath(){
		return $_ENV["ROOT"] . $this->PATH["CONTROLLER"] . $this->controller . ".php";
	}


	/**
	 * Return the current controller name
	 *
	 * @return [string]
	 */
	public function getControllerName(){
		return $this->controller;
	}
	
	/**
	 * Parse route.ini file and assign values to attributes
	 *
	 * @return void
	 */
	private function parseRoutesFile(){
		$routesIniFile = $_ENV["ROOT"] . $this->PATH["CONF"] . 'routes.ini';
		if(is_file($routesIniFile))	{
			$parsedRoutesFile = parse_ini_file($routesIniFile, false);
			$this->routes = $parsedRoutesFile['ROUTE'];
			$this->defaultRoute = $parsedRoutesFile['DEFAULT_ROUTE'];
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
		$this->controller = ucfirst($this->currentRoute.'Controller');
		if (!(file_exists($_ENV["ROOT"] . $this->PATH["CONTROLLER"] . $this->controller . ".php"))) {
			$this->controller = ucfirst($this->defaultRoute .'Controller');
		}
	}

}













