<?php

namespace Rookie\Kernel;

use Dotenv\Dotenv;
use Exception;
use Rookie\Kernel\Router;

/**
 * @author Cyril VASSALLO
 * Contain Loading Methods
 */
class Loader
{

    /**
     * Loader of Rookie
     * @return void
     */
    public function Rookie()
    {
        $DOCUMENT_ROOT = getcwd();
        $dotenv = Dotenv::createImmutable($DOCUMENT_ROOT . '/../');
        $dotenv->load();
        $_ENV['ROOT'] = $DOCUMENT_ROOT . '/../';
        $this->initEnvVars('rookie');
        //Start the session
        session_start();
        //Route the application
        $router = new Router();
        $hasErrorRoute = $router->getHasErrorRoute();
        //Execute the required Controller
        try
        {
            $app = $router->getControllerInstance();
            if($hasErrorRoute){
                !$app->hasError ?  $response = $app->getControllerResponse() :  header("Location:".$router->getErrorRoute());
            }else{
                $response = $app->getControllerResponse();
            }
   
            echo $response;
        } catch (Exception $e) {
            echo $e;
        }
        //Destroy the app object
        unset($app);
    }

    /**
     * Loader for PHPUnit
     * @return void
     */
    public function Tests()
    {
        $DOCUMENT_ROOT = getcwd();
        $dotenv = Dotenv::createImmutable($DOCUMENT_ROOT . '/');
        $dotenv->load();
        $_ENV['ROOT'] = $DOCUMENT_ROOT . '/';
        $this->initEnvVars('tests');
    }

    /**
     * Add all PATHS in $_ENV
     * @return void
     */
    private function initEnvVars(string $mode)
    {
        $this->_PATH = $this->paths($mode);
        foreach ($this->_PATH as $key => $value) {
            $_ENV[$key] = $value;
        }
    }

    /**
     * Load the config_xxx.ini files and return an array of path
     * @return array
     */
    private function paths(string $mode = "rookie")
    {
        try {
            // GET CURRENT WORKING DIRECTORY
            $mode !== 'tests' ? $DOCUMENT_ROOT = getcwd() : $DOCUMENT_ROOT = getcwd() . '/'. $mode;
            $aOfPaths = explode("/", $DOCUMENT_ROOT);
            for ($i = count($aOfPaths) - 1; $i > 0; $i--) {
                $DOCUMENT_ROOT = str_replace($aOfPaths[$i], "", $DOCUMENT_ROOT);
                $DOCUMENT_ROOT = str_replace("//", "/", $DOCUMENT_ROOT);
                if (is_file($DOCUMENT_ROOT . "config/paths_dev.ini") && $_ENV['APP_ENV'] === 'dev') {
                    return parse_ini_file($DOCUMENT_ROOT . "config/paths_dev.ini", false);
                } else if (is_file($DOCUMENT_ROOT . "config/paths_prod.ini") && $_ENV['APP_ENV'] === 'prod') {
                    return parse_ini_file($DOCUMENT_ROOT . "config/paths_prod.ini", false);
                } else {
                    throw new Exception('Sorry, something need to be checked in your application paths configuration !! <br/><br/>');
                }
            }
        } catch (Exception $e) {
            echo $e;
        }
    }

}
