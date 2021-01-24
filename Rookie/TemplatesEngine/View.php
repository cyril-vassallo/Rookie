<?php
namespace Rookie\TemplateEngine;

require_once $PATH["PATH_ROOT"] . $PATH["PATH_AUTOLOAD"];


use Twig\Environment;
use Rookie\Kernel\Configuration;
use Twig\Loader\FilesystemLoader;

/**
 * Init Twig with a static method
 */
class View {
    /**
     * Configure, instantiate and return a twig object
     * @return object $twig
     */
    public static function getTwig(){
        $PATH= Configuration::getPaths();
        $loader = new FilesystemLoader($PATH["PATH_ROOT"] . $PATH["PATH_VIEW"]);
        $twig = new Environment($loader);
        $twig->addGlobal('SESSION', $_SESSION);
        return $twig;
    }
}

?>