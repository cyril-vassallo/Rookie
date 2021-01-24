<?php
namespace App\Services;

use Rookie\DataComponent\Initialize;

require_once $PATH["PATH_ROOT"] . $PATH["PATH_DB"]."Initialize.php";

/**
 * @Service
 * @Target Entity: Movies
 */
class MoviesServices extends Initialize	{
	
	public function __construct()	{
		parent::__construct();
	}


	public function __destruct()	{
		parent::__destruct();
	}

	/**
	 * Getter of the database query results
	 *
	 * @return array
	 */
	public function getQueryResults(){
		return $this->queryResults;
	}

	/**
	 * @Select
	 *
	 * @param array $payload
	 * @return void
	 */
	public function selectMovies(array $payload)	{
		$pathSQL = $this->PATH["PATH_ROOT"] . $this->PATH["PATH_SQL"] . "movies/select_movies.sql";
		$this->queryResults = $this->database->getSelectData($pathSQL , array());
	}

	/**
	 * @Select
	 *
	 * @param array $payload
	 * @return void
	 */
	public function selectMovie(array $payload){
		$pathSQL = $this->PATH["PATH_ROOT"] . $this->PATH["PATH_SQL"] . "movies/select_movie.sql";
		$this->queryResults = $this->database->getSelectData($pathSQL , array( "id" => $payload["id"] ));
		
	}

	/**
	 * @Insert
	 *
	 * @param array $payload
	 * @return void
	 */
	public function insertMovie(array $payload)	{
		$pathSQL = $this->PATH["PATH_ROOT"] . $this->PATH["PATH_SQL"] . "movies/insert_movie.sql";
		$this->database->treatData($pathSQL , array(
													"title" => $payload["title"], 
													"created_at" => $payload["created_at"], 
													"duration" => $payload["duration"]
													));
		$this->queryResults["id"] = $this->database->getLastInsertId();
	}
	

	/**
	 * @Delete
	 *
	 * @param array $payload
	 * @return void
	 */
	public function deleteMovie(array $payload){
		$pathSQL = $this->PATH["PATH_ROOT"] . $this->PATH["PATH_SQL"] . "movies/delete_movie.sql";
		$this->database->treatData($pathSQL , array(
													"id" => $payload["id"]
													));
		$this->queryResults = array(
									"code" => 200,
									"id" => $payload["id"],
									"message" => "has been removed"
								);
	}

	/**
	 * @Update
	 *
	 * @param array $payload
	 * @return void
	 */
	public function updateMovie(array $payload){
		$pathSQL = $this->PATH["PATH_ROOT"] . $this->PATH["PATH_SQL"] . "movies/update_movie.sql";
		$this->database->treatData($pathSQL , array(
													"id" => $payload["id"], 
													"title" => $payload["title"], 
													"created_at" => $payload["created_at"], 
													"duration" => $payload["duration"]
													));

		$this->queryResults = array(
									"code" => 200,
									"id" => $payload["id"],
									"message" => "has been updated"
								);
	}
}

?>
