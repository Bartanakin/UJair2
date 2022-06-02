<?php

declare(strict_types=1);
namespace App;


use App\Exceptions\ViewNotFoundException;

class View
{
    public function __construct(
        protected ViewPaths $viewFileName,
        protected array $params = []
    ){

    }

    public static function make(ViewPaths $viewFileName, array $params = []): static
    {
        return new static($viewFileName,$params);
    }

    public function render(): string {
        if( $this -> viewFileName -> value[0] == '/' ){
            header("Location: ".$this -> viewFileName -> value);
            exit;
        }
        $path = VIEW_PATH . "/" . $this -> viewFileName -> value . ".php";

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

    public function getPath(): ViewPaths{
        return $this -> viewFileName;
    }
    public function getParams(): array {
        return $this -> params;
    }
}