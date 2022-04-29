<?php

namespace App;

abstract class Model
{
    static public string $dateFormat = 'Y-m-d H:i:s';
    protected function __construct()
    {
    }

    protected function getDBConnection(){
        return App::getDataBaseConnection() -> getPDO();
    }
}