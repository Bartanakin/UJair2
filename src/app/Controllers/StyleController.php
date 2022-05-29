<?php

namespace App\Controllers;

class StyleController
{
    const STYLES_PATH = "./../../views/styles";

    private function load($path){
        header("Content-type: text/css");
        ob_start();

        include __DIR__ .$path;

        echo ob_get_clean();
    }

    public function loginPage(){
        $this -> load(static::STYLES_PATH."/loginPageStyles.css");
    }
    public function allFlights(){
        $this -> load(static::STYLES_PATH."/allFlightsStyles.css");
    }
    public function common(){
        $this -> load(static::STYLES_PATH."/common.css");
    }
    public function JsCalendar(){
        $this -> load("./../../vendor/jsCalendar/source/jsCalendar.css");
    }

    public function flightEditor(){
        $this -> load(static::STYLES_PATH."/flightEditorStyles.css");
    }
    public function confirmationPage(){
        $this -> load(static::STYLES_PATH."/confirmationStyles.css");
    }
    public function crewPage(){
        $this -> load(static::STYLES_PATH."/crewStyles.css");
    }

}