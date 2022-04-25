<?php

namespace App;

abstract class Model
{
    protected $dbConnection;
    static public string $dateFormat = 'Y-m-d H:i:s';
    protected function __construct()
    {
        $this -> dbConnection = App::getDataBaseConnection() -> getPDO();
    }
}