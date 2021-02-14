<?php
namespace Rookie\DataComponent;

use Rookie\Kernel\Loader;
use Rookie\DataComponents\Database;


/**
 * @author Cyril VASSALLO <cyrilvssll34@gmail.com>
 * This class contain à constructor to initialize data access to the service layer
 */
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
		$this->PATH = Loader::pathsLoader();
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
