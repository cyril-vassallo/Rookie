<?php
namespace Rookie\Legacy;

use Rookie\TemplateEngine\View;
use Rookie\HttpComponents\Request;

require_once $PATH["PATH_ROOT"] . $PATH["PATH_HTTP"]. "Request.php";
require_once $PATH["PATH_ROOT"] . $PATH["PATH_ENGINE"] . "View.php";

class Controller {

    public $jsonResponse;
    protected $request;
    protected $twig;
    

    public function __construct()
    {
        $this->jsonResponse = [];
        $this->request = new Request();
        $this->twig = View::getTwig();
    }

    public function __destruct()	{
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

?>