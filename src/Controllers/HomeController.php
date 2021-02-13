<?php

namespace App\Controllers;

use Rookie\Legacy\Controller;
use App\Services\MoviesServices;

require_once $_ENV["ROOT"] . $PATH["SERVICES"]. "MoviesServices.php";
require_once $_ENV["ROOT"] . $PATH["LEGACY"]. "Controller.php";

/**
 * @Controller
 * @Route: 'movies'
 */
class HomeController extends Controller {

	private $moviesService;

	public function __construct()	{
		parent::__construct();
		$this->HomeController($this->request->method, $this->request->JSON);

	}

	public function __destruct()	{
		parent::__destruct();
	}

	/**
	 * Control the action server according to different methods for the home route 
	 *
	 * @param string $method
	 * @return void
	 */
	private function HomeController(string $method, bool $JSON){
		if(!$JSON && $method === 'VIEW'){
			$this->InitialView($this->request->payload);
		}
	}


	/**
	 * Read a movies Collection
	 * @Query: 'GET'
	 * @method: 'VIEW'
	 * @Response: 'Content-Type: text/Html'
	 */
	 private function InitialView(array $payload)	{
		 $controllerData = [
			'title' => 'Hey Rookie, Welcome !', 
			'welcome' => 'I\'m the from scratch framework for PHP Rookie developer !',
			'thisController' => 'HomeController',
			'nextController' => 'MoviesController',
			'route' => 'movies'
		 ];
		echo $this->twig->render('home/home.html.twig', $controllerData);
	}

	


}
?>
