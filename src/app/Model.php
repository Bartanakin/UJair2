<?php

namespace App;

abstract class Model
{
    protected $dbConnection;
    protected function __construct()
    {
        $this -> dbConnection = App::getDataBaseConnection() -> getPDO();
    }
}