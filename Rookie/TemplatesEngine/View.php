<?php
namespace Rookie\TemplateEngine;

use Rookie\Kernel\Loader;
use Twig\Environment;
use Twig\Extension\DebugExtension;
use Twig\Loader\FilesystemLoader;

/**
 * @author Cyril VASSALLO
 * Init Twig with a static method
 */
class View
{

    /**
     * Configure, instantiate and return a twig object
     * @return object $twig
     */
    public static function getTwig()
    {
        $PATH = Loader::pathsLoader();
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
