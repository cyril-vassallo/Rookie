<?php
namespace Rookie\HttpComponents;

use Rookie\Kernel\Loader;
/**
 * Filter and secure variables from http requests 
 * Variables can be used in all layers with th request Object  
 */
class Request {

	private $PATH;
	public $method;
	public $bJSON;
	public $query;
	public $payload;
	
	function __construct()	{
		$this->PATH = Loader::getPATHS();
		$this->query= [];
		$this->payload = [];
		$this->bJSON = true;
		$this->method = 'VIEW';
		$this->setPostPayload();
		$this->setGetQuery();
		$this->isRouteParamExist();
		$this->isJsonParamExist();
		$this->isMethodParamExist();
	}

	private function setPostPayload(){
		foreach($_POST as $key => $val)	{
			$this->payload[$key]= htmlspecialchars($val, ENT_QUOTES);
		}
	}

	private function setGetQuery(){
		foreach($_GET as $key => $val)	{
			$this->query[$key]= htmlspecialchars($val, ENT_QUOTES);
		}
	}

	private function isRouteParamExist(){
		if ((!isset($this->payload["route"])) || $this->payload["route"] == '')	{
			$routesIniFile = $_ENV["ROOT"] . $this->PATH["CONF"] . 'routes.ini';
			if(is_file($routesIniFile))	{
				$parsedRoutesFile = parse_ini_file($routesIniFile, false);
				$this->payload["route"] = $parsedRoutesFile['DEFAULT_ROUTE'];
			}
		}
	}

	private function isJsonParamExist(){
		if(!(isset($this->payload["bJSON"])) || $this->payload["bJSON"] == false) {
			$this->bJSON = false;
		}else{
			$this->bJSON = true;
		}
	}
	
	private function isMethodParamExist(){
		if(!(isset($this->payload["method"])) || $this->payload["method"] == '') {
			$this->method = strtoupper($this->payload["method"] = 'VIEW');
		}else {
			$this->method = $this->payload['method'];
		}
	}
	
}
?>