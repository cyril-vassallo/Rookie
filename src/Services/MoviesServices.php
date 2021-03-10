<?php
namespace App\Services;

use Rookie\DataComponents\Initialize;

/**
 * @Service
 * @Target Entity: Movies
 */
class MoviesServices extends Initialize
{
    private $getQueryResults;

    public function __construct()
    {
        parent::__construct();
        $this->queryResults = null;
    }

    public function __destruct()
    {
        parent::__destruct();
    }

    /**
     * Getter of the database query results
     *
     * @return allType
     */
    public function getQueryResults()
    {
        return $this->queryResults;
    }

    /**
     * @Select
     *
     * @return void
     */
    public function selectMovies()
    {
        $pathSQL = $_ENV["ROOT"] . $_ENV["SQL"] . "movies/select_movies.sql";
        $this->queryResults = $this->database->search($pathSQL, array());
    }

    /**
     * @Select
     *
     * @param array $payload
     * @return void
     */
    public function selectMovie(array $payload)
    {
        $pathSQL = $_ENV["ROOT"] . $_ENV["SQL"] . "movies/select_movie.sql";
        $this->queryResults = $this->database->search($pathSQL, array("id" => $payload["id"]));

    }

    /**
     * @Insert
     *
     * @param array $payload
     * @return void
     */
    public function insertMovie(array $payload)
    {

        $pathSQL = $_ENV["ROOT"] . $_ENV["SQL"] . "movies/insert_movie.sql";
        $this->database->mutate($pathSQL, array(
            "title" => $payload["title"],
            "created_at" => $payload["created_at"],
            "duration" => $payload["duration"],
        ));
        $id = $this->database->findLastInsertId();
        if ($id) {
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
    public function deleteMovie(array $payload)
    {
        if (isset($payload["id"])) {
            $this->selectMovie($payload);
        }
        $pathSQL = $_ENV["ROOT"] . $_ENV["SQL"] . "movies/delete_movie.sql";
        $this->database->mutate($pathSQL, array(
            "id" => $payload["id"],
        ));
    }

    /**
     * @Update
     *
     * @param array $payload
     * @return void
     */
    public function updateMovie(array $payload)
    {   
        $pathSQL = $_ENV["ROOT"] . $_ENV["SQL"] . "movies/update_movie.sql";
        $this->database->mutate($pathSQL, array(
            "id" => $payload["id"],
            "title" => $payload["title"],
            "created_at" => $payload["created_at"],
            "duration" => $payload["duration"],
        ));
        if (isset($payload["id"])) {
            $this->selectMovie($payload);
        }
    }
}
