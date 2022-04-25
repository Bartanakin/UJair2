<?php

namespace App\Entities;

class Airport{
    public function __construct(protected int $id, protected string $airportName) {

    }
}