<?php

namespace Rookie\HttpComponents;

use Rookie\TemplatesEngine\View;
use Rookie\Kernel\ErrorException;
use Rookie\HttpComponents\Request;

class Response
{

    private $request;
    private $twig;
    public $content;

    public function __construct($request)
    {
        $this->request = $request;
        $this->content = '';
        $this->twig = View::getTwig();
    }

    public function __destruct()
    {
        unset($this->request);
        unset($this->twig);
        unset($this->content);
    }


    public function create($data = ['error' => 'Sorry ! it seems like you do not have any data to display...'], int $code = 200 , string $template = '')
    {
        return $this->request->json ? $this->JSON($data, $code) : $this->VIEW($data, $template, $code);
    }

    /**
     * Prepare the JSON response
     *
     * @param array $data
     * @param int $code
     * @return void
     */
    public function JSON($data, int $code = 200)
    {
        header("Content-type:application/json");
        http_response_code($code);
        return json_encode($data);
    }

    /**
     * Prepare the HTML response
     *
     * @param string $template
     * @param array $data
     * @param int $code
     * @return $this->twig
     */
    public function VIEW(array $data, string $template, int $code)
    {
        if (file_exists($_ENV['ROOT'] . $_ENV['VIEW'] . $template)) {
            header("Content-type:text/html");
            http_response_code($code);
            return $this->twig->render($template, $data);
        } else {
            new ErrorException("Sorry !  It seems like the required template is missing !");
        }
    }

}
