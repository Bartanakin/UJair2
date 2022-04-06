<?php

declare(strict_types=1);

namespace Tests\Unit;

use App\Exceptions\UnknownUriException;
use App\Router;
use PHPUnit\Framework\TestCase;

class RouterTest extends TestCase
{

    private Router $router;
    private $user;

    protected function setUp(): void {
        parent::setUp();
        
        $this -> router = new Router();
        
        $this -> user = new class() {
            public function login(): bool {
                return true;
            }
            public function index(): array {
                return [1,2,3,4];
            }
        };

    }

    /** @test */
    public function it_registers_a_route(): void {
        // when
        $this -> router -> register("GET","/users",["Users","index"]);
        // then
        $expected = [
            "/users" => [
                "GET" => ["Users","index"]
            ]
        ];

        $this -> assertEquals($expected,$this -> router->routes());
    }

    /**
     * @test
     * @dataProvider \Tests\DataProviders\RouterDataProvider::UnknownUriCases
     */
    public function it_throws_unknown_uri_esception(
        string $uri,
        string $method
    ): void {

        $this -> router -> get("/users",["User","login"]);
        $this -> router -> post("/users",[$this -> user::class,"users"]);

        $this -> expectException(UnknownUriException::class);
        $this -> router -> resolve($method,$uri);
    }

    /** @test */
    public function it_tests_resolution_from_a_closure(): void {
        $this -> router -> get('/users', fn() => [1,2,3,4]);

        $this -> assertEquals([1,2,3,4],$this -> router -> resolve('GET','/users'));
    }
    /** @test */
    public function it_tests_resolution_a_route(): void {
        $this -> router -> get('/users', [$this -> user::class,"index"]);

        $this -> assertEquals([1,2,3,4], $this -> router -> resolve("GET",'/users'));
    }
}