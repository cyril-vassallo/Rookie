<?php
declare (strict_types = 1);

namespace App\Tests\Controllers;

use App\Controllers\CatsController;
use PHPUnit\Framework\TestCase;
use Rookie\DataComponents\LogMaker;
use Rookie\Kernel\Loader;

class CatsControllerTest extends TestCase
{
    private $catsController;
    private $log;

    protected function setUp(): void
    {
        $loader = new Loader();
        $loader->Tests();
        $this->catsController = new CatsController();
        $this->log = new LogMaker();
    }

    /** @test */
    public function testCatsControllerWhenInitialView()
    {
        $result = $this->catsController->CatsController('VIEW', false, ['format' => 'html', "method" => "get"], []);
        $this->assertNotEmpty($result);
    }

    /** @test */
    public function catsControllerWhenGetCat()
    {
        $result = $this->catsController->CatsController('GET', true, [], ['format' => 'json', "method" => "get", "id" => 1]);
        $this->assertNotEmpty($result);
    }

    /** @test */
    public function catsControllerWhenPostCat()
    {
        $result = $this->catsController->CatsController('POST', true, [], [
            'format' => 'json',
            "method" => "post",
            "name" => 'Caty TNT',
            'style' => 'dangerous',
            "age" => 4,
            "owner" => "Paul Smith",
        ]);
        $this->assertNotEmpty($result);
    }

    /** @test */
    public function catsControllerWhenUpdateCat()
    {
        $result = $this->catsController->CatsController('PUT', true, [], [
            'format' => 'json',
            "method" => "put",
            "id" => 3,
            "name" => 'Caty TNT',
            'style' => 'dangerous',
            "age" => 3,
            "owner" => "Paul Smith",
        ]);
        $this->assertNotEmpty($result);
    }

    /** @test */
    public function catsControllerWhenDeleteCat()
    {
        $result = $this->catsController->CatsController('DELETE', true, [], [
            'format' => 'json',
            "method" => "delete",
            "id" => 3,
        ]);
        $this->assertNotEmpty($result);
    }

    /** @test */
    public function catsControllerWhenQueryStringAndPayloadAreEmpty()
    {
        $result = $this->catsController->CatsController('GET', true, [], []);
        $this->assertTrue($this->catsController->hasError);
        $this->assertEmpty($result);
    }

    /** @test */
    public function catsControllerWhenViewHasNoQueryString()
    {
        $result = $this->catsController->CatsController('VIEW', true, [], []);
        $this->assertTrue($this->catsController->hasError);
        $this->assertEmpty($result);
    }

}
