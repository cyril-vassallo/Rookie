<?php
namespace Rookie\Legacy;

use Rookie\Kernel\Loader;
use Rookie\TemplateEngine\View;
use Rookie\Kernel\ErrorException;
use Rookie\HttpComponents\Request;

/**
 * @author Cyril VASSALLO
 * Init object in constructor and provide necessary methods for controllers
 */
class Controller
{

    protected $request;
    private $twig;
    private $PATH;

    public function __construct()
    {
        $this->request = new Request();
        $this->twig = View::getTwig();
        $this->PATH = Loader::pathsLoader();
    }

    public function __destruct()
    {
        unset($this->request);
        unset($this->twig);
        unset($this->PATH);
    }

    /**
     * Prepare the JSON response
     *
     * @param array $data
     * @param int $code
     * @return void
     */
    protected function JSON(array $data = ['error'=> 'Sorry ! it seems like you do not have any data to display...'], int $code = 200)
    {
        header("Content-type:application/json");
        http_response_code($code);
        echo json_encode($data);
    }

      /**
     * Prepare the HTML response
     *
     * @param string $template
     * @param array $data
     * @param int $code
     * @return void
     */
    protected function VIEW(string $template, array $data, int $code = 200)
    {
        if(file_exists($_ENV['ROOT'].$this->PATH['VIEW'].$template)){
            header("Content-type:text/html");
            http_response_code($code);
            echo $this->twig->render($template, $data);
        }else {
            new ErrorException("Sorry !  It seems like the required template is missing !");
        }
    }

    
}
