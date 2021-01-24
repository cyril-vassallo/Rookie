<?php
namespace Rookie\DataComponent;

use Rookie\Kernel\Configuration;
use Rookie\DataComponents\Database;

require_once $PATH["PATH_ROOT"] . $PATH["PATH_DB"]."Database.php";


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
		$this->PATH = Configuration::getPaths();
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
