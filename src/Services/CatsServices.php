<?php

namespace App\Services;

use Rookie\DataComponent\Initialize;

class CatsServices extends Initialize
{

    public function __construct()
    {
        parent::__construct();
    }

    public function __destruct()
    {
        parent::__destruct();
    }

    /**
     * GETTER of the database query results
     * @return unknown 
     */
    public function getQueryResults()
    {
        //provided by Initialize
        return $this->queryResults;
    }

    /**
     * SELECT a collection of cat
     * @param payload
     * @return void
     */
    public function selectCats(): void
    {
        $pathSQL = $_ENV["ROOT"] . $this->PATH["SQL"] . "cats/select_cats.sql";
        $this->queryResults = $this->database->search($pathSQL);
    }

    /**
     * SELECT a Cat
     * @param payload
     * @return void
     */
    public function selectCat(array $payload): void
    {
        $pathSQL = $_ENV["ROOT"] . $this->PATH["SQL"] . "cats/select_cat.sql";
        $this->queryResults = $this->database->search($pathSQL, ["id" => $payload["id"]]);
    }

    /**
     * INSERT a Cat
     * @param payload
     * @return void
     */
    public function insertCat(array $payload): void
    {
        $pathSQL = $_ENV["ROOT"] . $this->PATH["SQL"] . "cats/insert_cat.sql";
        $this->database->mutate($pathSQL, [
            "name" => $payload["name"],
            "style" => $payload["style"],
            "owner" => $payload["owner"],
            "age" => $payload["age"]
        ]);

        $id = $this->database->findLastInsertId();
        if ($id) {
            $payload = ['id' => $id];
            $this->selectCat($payload);
        }
    }

    /**
     * UPDATE a cat
     * @param payload
     * @return void
     */
    public function updateCat(array $payload): void
    {
        $pathSQL = $_ENV["ROOT"] . $this->PATH["SQL"] . "cats/update_cat.sql";
        $this->database->mutate($pathSQL, [
            "id" => $payload["id"],
            "name" => $payload["name"],
            "style" => $payload["style"],
            "owner" => $payload["owner"],
            "age" => $payload["age"]
        ]);
        if (isset($payload["id"])) {
            $this->selectCat($payload);
        }
    }

    /**
     * DELETE a cat
     * @param payload
     * @return void
     */
    public function deleteCat(array $payload): void
    {   
        if (isset($payload["id"])) {
            $this->selectMovie($payload);
        }
        $pathSQL = $_ENV["ROOT"] . $this->PATH["SQL"] . "cats/delete_cat.sql";
        $this->queryResults = $this->database->mutate($pathSQL, ["id" => $payload["id"]]);
    }

}


?>