<?php
namespace Rookie\DataComponents;

use PDO;
use PDOException;

/**
 * Class Database | file Database.php
 */
Class Database {
	
	private $_CONNECTION_HANDLER;
	
	/**
	 * Connect to the database
	 */
	//function __construct($host, $name, $login, $password)	{
	function __construct()	{
		try {
			//$this->_CONNECTION_HANDLER= new PDO('mysql:host='.$host.';dbname='.$name.';charset=utf8',$login,$password);
			$this->_CONNECTION_HANDLER= new PDO($_ENV['DATABASE_URL'], $_ENV['DB_LOGIN'], $_ENV['DB_PSW']);
		}
		catch (PDOException $error) {
			error_log("PDOException Connection to DB = " . $error->getMessage());
		}
	}

	/**
	 * Disconnect from the database
	 */
	function __destruct()	{
		$this->_CONNECTION_HANDLER= null;
	}
	
	/**
	 * Get the last id inserted
	 */
	public function getLastInsertId()	{
		return $this->_CONNECTION_HANDLER->lastInsertId();
	}

	/**
	 * Execute select method
	 */
	function getSelectData($pathSQL, $data=array(), $bForJS=null)	{
		$sql= file_get_contents($pathSQL);
		foreach ($data as $key => $value) {
			$value= str_replace("'", "__SIMPLEQUOT__", $value);
			$value= str_replace('"', '__DOUBLEQUOT__', $value);
			$value= str_replace(";", "__POINTVIRGULE__", $value);
			$sql = str_replace('@'.$key, $value, $sql);
			error_log("key = " . $key . " | " . "value= " . $value. " | " . "sql = " . $sql);
		}

		error_log("getSelectData = " . $sql);

		$result= [];
		$result["error"]= "";
		try {
			$results_db = $this->_CONNECTION_HANDLER->prepare($sql);
			$results_db->execute();
		}
		catch (PDOException $error) {
			$result["error"]= $error->getMessage();
			error_log("PDOException getSelectData = " . $result["error"]);
		}

		if ($result["error"] == "")	{
			$result= [];
			while ($row = $results_db->fetch()) {
				$new_row= [];
				foreach ($row as $key => $value) {
					if (!(is_numeric($key)))	{
						error_log("getSelectData DETAILS = " . $key . " => " . $value);
						if ((isset($bForJS)) && (($bForJS == 1) || ($bForJS == 2)))	{
							$value= str_replace("__SIMPLEQUOT__", "'", $value);
							$value= str_replace('__DOUBLEQUOT__', '\"', $value);
							$value= str_replace("__POINTVIRGULE__", ";", $value);
						}  else  {
							$value= str_replace("__SIMPLEQUOT__", "'", $value);
							$value= str_replace('__DOUBLEQUOT__', '"', $value);
							$value= str_replace("__POINTVIRGULE__", ";", $value);
						}
						$new_row[$key]= $value;
					}
				}
				$result[]= $new_row;
			}
		}

		return $result;
	}

	/**
	 * Execute insert / update / delete method
	 */
	function treatData($pathSQL, $data=array())	{

		$sql= file_get_contents($pathSQL);
		foreach ($data as $key => $value) {
			$value= str_replace("'", "__SIMPLEQUOT__", $value);
			$value= str_replace('"', '__DOUBLEQUOT__', $value);
			$value= str_replace(";", "__POINTVIRGULE__", $value);
			$sql= str_replace('@'.$key, $value, $sql);
		}
		error_log("treatData = " . $sql);

		$result= [];
		$result["error"]= "";
		try {
			$this->_CONNECTION_HANDLER->query($sql);
		}
		catch (PDOException $error) {
			$result["error"]= $error->getMessage();
			error_log("PDOException treatData = " . $result["error"]);
		}

		return $result;
	}

}
	
?>
