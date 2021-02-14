<?php
namespace Rookie\Legacy;

use Rookie\HttpComponents\Request;
use Rookie\TemplateEngine\View;

/**
 * @author Cyril VASSALLO
 * Init object in constructor and provide necessary methods for controllers
 */
class Controller
{

    protected $request;
    protected $twig;

    public function __construct()
    {
        $this->request = new Request();
        $this->twig = View::getTwig();
    }

    public function __destruct()
    {
        unset($this->request);
        unset($this->twig);
    }

    /**
     * Prepare the JSON response
     *
     * @param array $data
     * @param string $code
     * @return void
     */
    protected function JSON(array $data, int $code)
    {
        header("Content-type:application/json");
        http_response_code($code);
        echo json_encode($data);
    }
}
