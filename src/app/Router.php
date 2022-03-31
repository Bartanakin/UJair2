<?php
declare(strict_types=1);

namespace App;


use App\Exceptions\UnknownUriException;

class Router{
    private array $actions = [];

    private function register(string $method, string $uri, callable $action): self {
        $this -> actions[$uri][$method] = $action;

        return $this;
    }

    public function get( string $uri, callable $action ): self {
        return $this -> register("GET",$uri,$action);
    }

    public function post( string $uri, callable $action ): self {
        return $this -> register("POST",$uri,$action);
    }

    public function resolve( string $method, string $uri ){

        $uri = $this -> parseUri($uri);
        $action = $this -> actions[$uri][$method] ?? null;

        if( ! $action ){
            throw new UnknownUriException();
        }

        return call_user_func($action);
    }

    private function parseUri(string $uri): string {
        return explode("?",$uri)[0];
    }


}