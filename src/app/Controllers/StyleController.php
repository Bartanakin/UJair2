<?php

namespace App\Controllers;

class StyleController
{
    const STYLES_PATH = "./../../views/styles";

    private function load($path){
        header("Content-type: text/css");
        ob_start();

        include __DIR__ . static::STYLES_PATH.$path;

        echo ob_get_clean();
    }

    public function loginPage(){
        $this -> load("/loginPageStyles.css");
    }
    public function allFlights(){
        $this -> load("/allFlightsStyles.css");
    }
    public function common(){
        $this -> load("/common.css");
    }
}