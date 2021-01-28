<?php
namespace Rookie\TemplateEngine;

require_once $_ENV["ROOT"] . $PATH["PATH_AUTOLOAD"];


use Twig\Environment;
use Rookie\Kernel\Configuration;
use Twig\Loader\FilesystemLoader;
use Twig\Extension\DebugExtension;

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
        $loader = new FilesystemLoader($_ENV["ROOT"] . $PATH["PATH_VIEW"]);
        $twig = new Environment($loader, [
            'debug' => true,
            // ...
        ]);
        $twig->addExtension(new DebugExtension());
        $twig->addGlobal('SESSION', $_SESSION);
        return $twig;
    }
}

?>