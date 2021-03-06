<?php

namespace Rookie\Kernel;

use Exception;

/**
 * @author Cyril VASSALLO
 * Contain necessary statics methods  "pathLoader" and "classLoader" for Rookie engine
 */
class Loader
{

    /**
     * Load the config_xxx.ini files and return an array of Global Constants for path
     * @return array
     */
    public static function pathsLoader()
    {
        try {
            $DOCUMENT_ROOT = getcwd(); // GET CURRENT WORKING DIRECTORY
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

    /**
     * Callable for spl_autoload_register in index.php
     * @param string $namespace
     */
    public static function classLoader(string $namespace)
    {
        $splitNamespace = explode('\\', $namespace);
        $class = $splitNamespace[count($splitNamespace) - 1];
        if (file_exists($_ENV['ROOT'] . 'Rookie/Kernel/' . $class . '.php')) {
            require_once $_ENV['ROOT'] . 'Rookie/Kernel/' . $class . '.php';
        } else if (file_exists($_ENV["ROOT"] . 'src/Controllers/' . $class . '.php')) {
            require_once $_ENV["ROOT"] . 'src/Controllers/' . $class . '.php';
        } else if (file_exists($_ENV["ROOT"] . 'src/Services/' . $class . '.php')) {
            require_once $_ENV["ROOT"] . 'src/Services/' . $class . '.php';
        } else if (file_exists($_ENV["ROOT"] . 'Rookie/Legacy/' . $class . '.php')) {
            require_once $_ENV["ROOT"] . 'Rookie/Legacy/' . $class . '.php';
        } else if (file_exists($_ENV["ROOT"] . 'Rookie/HttpComponents/' . $class . '.php')) {
            require_once $_ENV["ROOT"] . 'Rookie/HttpComponents/' . $class . '.php';
        } else if (file_exists($_ENV["ROOT"] . 'Rookie/DataComponents/' . $class . '.php')) {
            require_once $_ENV["ROOT"] . 'Rookie/DataComponents/' . $class . '.php';
        } else if (file_exists($_ENV["ROOT"] . 'Rookie/TemplatesEngine/' . $class . '.php')) {
            require_once $_ENV["ROOT"] . 'Rookie/TemplatesEngine/' . $class . '.php';
        }else if (file_exists($_ENV["ROOT"] . 'tests/Controllers/' . $class . '.php')) {
            require_once $_ENV["ROOT"] . 'tests/Controllers/' . $class . '.php';
        }
    }
}
