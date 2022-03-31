<?php

declare(strict_types=1);
namespace App;


use App\Exceptions\ViewNotFoundException;

class View
{
    public function __construct(protected string $viewFileName, protected array $params = []){

    }

    public static function make(string $viewFileName, array $params = []): static
    {
        return new static($viewFileName,$params);
    }

    public function render(): string {

        $path = VIEW_PATH . "/" . $this -> viewFileName;

        if( ! file_exists($path) ){
            throw new ViewNotFoundException();
        }

        ob_start();

        include $path;

        return (string) ob_get_clean();
    }

    public function __toString(): string
    {
        return $this -> render();
    }
}