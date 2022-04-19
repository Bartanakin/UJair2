<?php

declare(strict_types=1);

namespace App;

use App\Exceptions\Container\ContainerException;
use App\Exceptions\Container\NotFoundException;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\ContainerInterface;
use Psr\Container\NotFoundExceptionInterface;

class Container implements ContainerInterface
{

    private array $entries = [];
    public function get(string $id)
    {
        if( $this -> has($id) ){
            $entry = $this -> entries[$id];

            if( is_callable($entry) ){
                return $entry($this);
            }

            $id = $entry;
        }
        return $this -> resolve($id);

        //throw new NotFoundException("Class has no binding!");
    }

    public function has(string $id): bool
    {
        return isset($this -> entries[$id]);
    }

    public function set(string $id, callable|string $concrete){
        $this -> entries[$id] = $concrete;
    }

    public function resolve(string $id)
    {
         $reflectionClass = new \ReflectionClass($id);
         if( ! $reflectionClass -> isInstantiable() ){
             throw new ContainerException("Class ".$id." is not instantiable");
         }

         $constructor = $reflectionClass -> getConstructor();

         if( ! $constructor ){
             return new $id;
         }

         $parameters = $constructor -> getParameters();

         if( ! $parameters ){
             return new $id;
         }

         $dependencies = array_map(
             function(\ReflectionParameter $param) use ($id) {
                $name = $param -> getName();
                $type = $param -> getType();
                if( ! $type ) {
                    throw new ContainerException("Failed to resolve class " . $id ." because param " . $name . " is missing type hint.");
                }
                if( $type instanceof \ReflectionUnionType ) {
                    throw new ContainerException("Failed to resolve class " . $id . " because of union type for " . $name . ".");
                }
                if( $type instanceof \ReflectionNamedType && ! $type -> isBuiltin() ){
                    return $this -> get($type -> getName());
                }
                 throw new ContainerException("Failed to resolve class " . $id . " because of invalid param named " . $name . ".");
                },
             $parameters
         );

         return $reflectionClass -> newInstanceArgs($dependencies);
    }
}