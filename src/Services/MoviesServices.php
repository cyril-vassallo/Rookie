<?php
namespace App\Services;

use Rookie\DataComponent\Initialize;

require_once $_ENV["ROOT"] . $PATH["PATH_DB"]."Initialize.php";

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
		$pathSQL = $_ENV["ROOT"] . $this->PATH["PATH_SQL"] . "movies/select_movies.sql";
		$this->queryResults = $this->database->search($pathSQL , array());
	}

	/**
	 * @Select
	 *
	 * @param array $payload
	 * @return void
	 */
	public function selectMovie(array $payload){
		$pathSQL = $_ENV["ROOT"] . $this->PATH["PATH_SQL"] . "movies/select_movie.sql";
		$this->queryResults = $this->database->search($pathSQL , array( "id" => $payload["id"] ));
		
	}

	/**
	 * @Insert
	 *
	 * @param array $payload
	 * @return void
	 */
	public function insertMovie(array $payload)	{

		$pathSQL = $_ENV["ROOT"] . $this->PATH["PATH_SQL"] . "movies/insert_movie.sql";
		$this->database->mutate($pathSQL , array(
													"title" => $payload["title"], 
													"created_at" => $payload["created_at"], 
													"duration" => $payload["duration"]
													));
		$id = $this->database->findLastInsertId();
		if($id){
			$payload = ['id' => $id];
			$this->selectMovie($payload);
		}
	}
	

	/**
	 * @Delete
	 *
	 * @param array $payload
	 * @return void
	 */
	public function deleteMovie(array $payload){
		if(isset($payload["id"])){
			$this->selectMovie($payload);
		}
		$pathSQL = $_ENV["ROOT"] . $this->PATH["PATH_SQL"] . "movies/delete_movie.sql";
		$this->database->mutate($pathSQL , array(
													"id" => $payload["id"]
													));
	}

	/**
	 * @Update
	 *
	 * @param array $payload
	 * @return void
	 */
	public function updateMovie(array $payload){
		$pathSQL = $_ENV["ROOT"] . $this->PATH["PATH_SQL"] . "movies/update_movie.sql";
		$this->database->mutate($pathSQL , array(
													"id" => $payload["id"], 
													"title" => $payload["title"], 
													"created_at" => $payload["created_at"], 
													"duration" => $payload["duration"]
													));
		if(isset($payload["id"])){
			$this->selectMovie($payload);
		}


	}
}

?>
