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
        $statement = $this -> getDBConnection() -> prepare($query);
        $value = rand(0,20000);
        $statement -> execute([$value]);
        return "Row with id ". $this -> getDBConnection() -> lastInsertId() . " has been inserted with value " . $value . " .";
    }
    public function printAll(): array {
        $query = 'SELECT * FROM TestTable;';
        $statement = $this -> getDBConnection() -> prepare($query);
        $statement -> execute();
        $data = $statement -> fetchAll();
        return $data ? $data : [];
    }
    
    public function check1() {
        $login = $_GET['login'];
        $password = $_GET['password'];
        $query = "SELECT doLoginAndPasswordExist('{$login}', '{$password}') AS answer;";
        $statement = $this -> getDBConnection() -> prepare($query);
        $statement -> execute();
        $data = $statement -> fetchAll();
        echo json_encode($data);
    }
}
