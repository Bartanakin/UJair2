<?php

namespace App\Interfaces;

interface PlannerLoginInterface
{
    public function login($login,$password): bool;
}