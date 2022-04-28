<?php

namespace App\Models;

use App\Interfaces\PlannerLoginInterface;
use App\Model;

class PlannerLoginImpl extends Model implements PlannerLoginInterface
{

    public function login($login, $password): bool
    {
        $stm = $this -> dbConnection -> prepare('SELECT * FROM planners WHERE username = ? AND password = ?;');

    }
}