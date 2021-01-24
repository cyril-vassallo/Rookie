<?php

//namespace App\Controllers;

use Rookie\Legacy\Controller;
use App\Services\MoviesServices;

require_once $PATH["PATH_ROOT"] . $PATH["PATH_SERVICES"]. "MoviesServices.php";
require_once $PATH["PATH_ROOT"] . $PATH["PATH_LEGACY"]. "Controller.php";

/**
 * @Controller
 * @Route: 'movies'
 */
class HomeController extends Controller {

	private $moviesService;

	public function __construct()	{
		parent::__construct();
		$this->HomeController($this->request->method, $this->request->bJSON);

	}

	public function __destruct()	{
		parent::__destruct();
	}

	/**
	 * Control the action server according to different methods for the movies route 
	 *
	 * @param string $method
	 * @return void
	 */
	private function HomeController(string $method, bool $bJSON){
		if(!$bJSON && $method === 'VIEW'){
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