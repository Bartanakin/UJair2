<?php

namespace App\Entities;

class Airplane
{
    public function __construct(
        protected ?int $ID = null,
        protected ?string $typeName = null
    ){

    }

    public static function createForAllFlights(
        int $ID,
        string $typeName
    )
    {
        return new static(ID: $ID, typeName: $typeName );
    }
}