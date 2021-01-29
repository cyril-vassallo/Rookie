<?php
namespace Rookie\TemplateEngine;

require_once $_ENV["ROOT"] . $PATH["AUTOLOAD"];


use Twig\Environment;
use Rookie\Kernel\Loader;
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
        $PATH= Loader::getPATHS();
        $loader = new FilesystemLoader($_ENV["ROOT"] . $PATH["VIEW"]);
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