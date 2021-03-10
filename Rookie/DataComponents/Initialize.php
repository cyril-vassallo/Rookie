<?php
namespace Rookie\DataComponents;

use Rookie\DataComponents\Database;

/**
 * @author Cyril VASSALLO
 * This class contain à constructor to initialize data access in the Services layer
 */
class Initialize
{

    /**
     * Database access Object for service
     *
     * @var [Object]
     */
    protected $database;

    /**
     * Database response after query for services
     *
     * @var [array]
     */
    protected $queryResults;

    /**
     * Create a database connection and init services variables and Constant
     */
    public function __construct()
    {
        $this->database = new Database();
        $this->queryResults = [];
    }

    /**
     * Destroy Instances
     */
    public function __destruct()
    {
        unset($this->database);
        unset($this->queryResults);
    }

}
