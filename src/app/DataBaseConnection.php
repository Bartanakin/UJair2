<?php

namespace App;

use PDO;

class DataBaseConnection
{
    protected PDO $pdoConnection;

    const DEFAULT_OPTIONS = [
        PDO::ATTR_EMULATE_PREPARES => false,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
    ];
    public function __construct(
        protected array $dbConfig
    ){
        try{
            $this -> pdoConnection = new PDO(
                'mysql:host='.$this->dbConfig['HOST'].";dbname=".$this->dbConfig["DATABASE"],
                $this -> dbConfig["USER"],
                $this -> dbConfig["PASSWORD"],
                $this -> dbConfig['OPTIONS'] ?? self::DEFAULT_OPTIONS
            );
        }
        catch( \PDOException $e ){
            throw new \PDOException($e ->getMessage(),(int)$e -> getCode());
        }
    }

    public function getPDO(){
        return $this -> pdoConnection;
    }
}