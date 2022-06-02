<?php

namespace App\Controllers;

class ScriptController
{
    const SCRIPT_PATH = "./../../views/scripts";

    private function load($path){
        header("Content-type: text/javascript");
        ob_start();

        include __DIR__ .$path;

        echo ob_get_clean();
    }

    public function JsCalendar(){
        $this -> load("./../../vendor/jsCalendar/jsCalendar/source/jsCalendar.js");
    }
}