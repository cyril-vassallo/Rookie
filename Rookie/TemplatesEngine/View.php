<?php
namespace Rookie\TemplatesEngine;

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
        //$_PATH = Loader::paths();
        $loader = new FilesystemLoader($_ENV["ROOT"] . $_ENV["VIEW"]);
        $twig = new Environment($loader, [
            'debug' => true,
            // ...
        ]);
        $twig->addExtension(new DebugExtension());
        if(isset($_SESSION)){
            $twig->addGlobal('SESSION', $_SESSION);
        }
        return $twig;
    }
}
