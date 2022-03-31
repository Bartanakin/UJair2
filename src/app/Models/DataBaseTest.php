<?php

namespace App\Models;

use App\Model;

class DataBaseTest extends Model
{
    public function __construct(){
        parent::__construct();
    }
    public function addRow(): string {
        $query = 'INSERT INTO TestTable (value1) VALUES (?);';
        $statement = $this -> dbConnection -> prepare($query);
        $value = rand(0,20000);
        $statement -> execute([$value]);
        return "Row with id ". $this -> dbConnection -> lastInsertId() . " has been inserted with value " . $value . " .";
    }
    public function printAll(): array {
        $query = 'SELECT * FROM TestTable;';
        $statement = $this -> dbConnection -> prepare($query);
        $statement -> execute();
        $data = $statement -> fetchAll();
        return $data ? $data : [];
    }
}
