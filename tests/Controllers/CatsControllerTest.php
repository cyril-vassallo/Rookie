<?php 

require __DIR__.'/../../Rookie/Kernel/TestLoader.php';

use PHPUnit\Framework\TestCase;
use App\Controllers\CatsController;


final class CatsControllerTest extends TestCase
{
 

    protected $catsController;
  

    protected function setUp():void
    {
        $this->catsController = new CatsController;
    }

    public function testCatsControllerInitialView()
    {
        $this->assertSame("initialView", $this->catsController->CatsController('VIEW', false, [], []));
    }


}
