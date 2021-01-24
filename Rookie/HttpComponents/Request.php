<?php
namespace Rookie\HttpComponents;

use Rookie\Kernel\Configuration;
/**
 * Filter and secure variables from http requests 
 * Variables can be used in all layers with th request Object  
 */
class Request {

	public $body;
	public $query;
	public $payload;
	public $bJSON;
	public $method;
	
	function __construct()	{
		$this->body= [];
		$this->query= [];
		$this->payload = [];
		$this->bJSON = true;
		$this->method = 'VIEW';
		$this->PATH = Configuration::getPaths();

		foreach($_POST as $key => $val)	{
			$this->body[$key]= htmlspecialchars($val, ENT_QUOTES);
			$this->payload[$key]= htmlspecialchars($val, ENT_QUOTES);
			
		}

		foreach($_GET as $key => $val)	{
			$this->query[$key]= htmlspecialchars($val, ENT_QUOTES);
			$this->payload[$key]= htmlspecialchars($val, ENT_QUOTES);
		}

		if ((!isset($this->payload["route"])) || $this->payload["route"] == '')	{
			$this->payload["route"] = $this->PATH['DEFAULT_ROUTE'];
		}
		if(!(isset($this->payload["bJSON"])) || $this->payload["bJSON"] == false) {
			$this->bJSON = false;
		}
		if(!(isset($this->payload["method"])) || $this->payload["method"] == '') {
			$this->method = strtoupper($this->payload["method"] = 'VIEW');
		}
	}
}
?>