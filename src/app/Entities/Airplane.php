<?php

namespace App\Entities;

class Airplane
{
    protected function __construct(
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

    /**
     * @return int|null
     */
    public function getID(): ?int
    {
        return $this->ID;
    }

    public function getTypeName(): string
    {
        return $this->typeName;
    }
}