<?php
namespace Rookie\DataComponent;

use Rookie\Kernel\Loader;
use Rookie\DataComponents\Database;

require_once $_ENV["ROOT"] . $PATH["DB"]."Database.php";


Class Initialize	{

	/**
	 * Database access Object for service
	 *
	 * @var [Object]
	 */
	protected $database;

	/**
	 * PATH Constants for services
	 *
	 * @var [array]
	 */
	protected $PATH;

	/**
	 * Request payload for services
	 *
	 * @var [array]
	 */
	protected $payload;

	/**
	 * Database response after query for services
	 *
	 * @var [array]
	 */
	protected $queryResults;

	/**
	 * Create a database connection and init services variables and Constant
	 */
	public function __construct()	{
		$this->PATH = Loader::getPATHS();
		$this->database = new Database();
		$this->queryResults = [];						   
	}

	/**
	 * Destroy Instances
	 */
	public function __destruct()	{
		unset($this->database);
	}

}

?>
