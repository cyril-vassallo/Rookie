<?php
namespace Rookie\DataComponent;

use Rookie\DataComponents\Database;
use Rookie\Kernel\Loader;

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
    public function __construct()
    {
        $this->PATH = Loader::pathsLoader();
        $this->database = new Database();
        $this->queryResults = [];
    }

    /**
     * Destroy Instances
     */
    public function __destruct()
    {
        unset($this->database);
    }

}
