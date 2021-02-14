<?php
namespace Rookie\DataComponents;

use PDO;
use PDOException;

/**
 * @author Cyril VASSALLO
 * Contain database access methods generally used in Services layer
 */
class Database
{

    private $_CONNECTION;

    /**
     * Connect to the database
     */
    public function __construct()
    {
        try {
            $this->_CONNECTION = new PDO($_ENV['DATABASE_URL'], $_ENV['DB_LOGIN'], $_ENV['DB_PSW']);
        } catch (PDOException $error) {
            error_log("PDOException Connection to DB = " . $error->getMessage());
        }
    }

    /**
     * Disconnect from the database
     */
    public function __destruct()
    {
        $this->_CONNECTION = null;
    }

    /**
     * Get the last id inserted
     */
    public function findLastInsertId()
    {
        return $this->_CONNECTION->lastInsertId();
    }

    /**
     * Execute select SQL
     */
    public function search($pathSQL, $data = array())
    {
        $sql = file_get_contents($pathSQL);
        error_log("search = " . $sql);
        $errorMessage = "";
        try {
            $databaseStatement = $this->_CONNECTION->prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
            $databaseStatement->execute($data);
        } catch (PDOException $error) {
            $errorMessage = $error->getMessage();
            error_log("PDOException search = " . $errorMessage);
        }

        if ($errorMessage == "") {
            return $databaseStatement->fetchAll(PDO::FETCH_ASSOC);
        }
    }

    /**
     * Execute insert / update / delete SQL
     */
    public function mutate($pathSQL, $data = array())
    {
        $sql = file_get_contents($pathSQL);
        error_log("mutate = " . $sql);
        $errorMessage = "";
        try {
            $databaseStatement = $this->_CONNECTION->prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
            $databaseStatement->execute($data);
        } catch (PDOException $error) {
            $errorMessage = $error->getMessage();
            error_log("PDOException mutate = " . $errorMessage);
        }

        if ($errorMessage == "") {
            return $errorMessage;
        }
    }

}
