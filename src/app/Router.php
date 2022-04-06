<?php
declare(strict_types=1);

namespace App;


use App\Exceptions\UnknownUriException;

class Router{
    private array $actions = [];

    public function register(string $method, string $uri, callable|array $action): self {
        $this -> actions[$uri][$method] = $action;

        return $this;
    }

    public function get( string $uri, callable|array $action ): self {
        return $this -> register("GET",$uri,$action);
    }

    public function post( string $uri, callable|array $action ): self {
        return $this -> register("POST",$uri,$action);
    }

    public function resolve( string $method, string $uri ){

        $uri = $this -> parseUri($uri);
        $action = $this -> actions[$uri][$method] ?? null;

        if( ! $action ){
            throw new UnknownUriException();
        }

        if( is_array($action) ){
            [$class, $method] = $action;
            if( class_exists($class) ){
                $class = new $class();

                if( method_exists($class,$method) ){
                    return call_user_func_array([$class,$method],[]);
                }
            }
        }
        if( is_callable($action) ){
            return call_user_func($action);
        }

        throw new UnknownUriException();
    }

    private function parseUri(string $uri): string {
        return explode("?",$uri)[0];
    }

    public function routes(): array {
        return $this -> actions;
    }


}