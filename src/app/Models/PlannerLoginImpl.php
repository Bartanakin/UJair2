<?php

namespace App\Models;

use App\Interfaces\PlannerLoginInterface;
use App\Model;

class PlannerLoginImpl extends Model implements PlannerLoginInterface
{
    public function __construct(){
        parent::__construct();
    }
    public function login($login, $password): bool
    {
        $passwordHash = password_hash($password,PASSWORD_DEFAULT);
        $stm = $this -> dbConnection -> prepare('SELECT * FROM Planners WHERE Username = ? AND PasswordHash = ?;');
        $stm -> execute([$login,$passwordHash]);
        return true;
    }
}