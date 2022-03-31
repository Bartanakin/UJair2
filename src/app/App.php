<?php

declare(strict_types=1);
namespace App;

class App
{
    private $router;

    function __construct(){
        $this -> router = new Router();
    }

    function getRouter(): Router {
        return $this -> router;
    }

    function run(){
        $this -> router -> resolve($_SERVER["REQUEST_METHOD"],$_SERVER["REQUEST_URI"]);
    }


}