<?php
namespace Rookie\Kernel;

use Exception;
/**
 * @author Cyril VASSALLO <cyrilvssll34@gmail.com>
 * This class provide a method to get Global Paths
 *
 */
Class Loader	{
	/**
	 * Read the config_xxx.ini files and return an array of Global CONST
	 * @return array
	 */
	public static function getPATHS() {
		try{
			$DOCUMENT_ROOT = getcwd(); // GET CURRENT WORKING DIRECTORY
			$aOfPaths= explode("/", $DOCUMENT_ROOT);
			for ($i=count($aOfPaths)-1; $i>0; $i--)	{
				$DOCUMENT_ROOT= str_replace($aOfPaths[$i], "", $DOCUMENT_ROOT);
				$DOCUMENT_ROOT= str_replace("//", "/", $DOCUMENT_ROOT);
				if (is_file($DOCUMENT_ROOT . "config/paths_dev.ini") && $_ENV['APP_ENV'] === 'dev')	
				{
					return parse_ini_file($DOCUMENT_ROOT . "config/paths_dev.ini", false);
				}  
				else if (is_file($DOCUMENT_ROOT . "config/paths_prod.ini") && $_ENV['APP_ENV'] === 'prod') 
				{
					return parse_ini_file($DOCUMENT_ROOT . "config/paths_prod.ini", false);
				} 
				else {
					throw new Exception('Sorry, something need to be checked in your application paths configuration !! <br/><br/>');
				}
			}
		}catch(Exception $e){
			echo $e ;
		}
	}
	
}

?>

