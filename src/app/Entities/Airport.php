<?php

namespace App\Entities;

use JetBrains\PhpStorm\Internal\TentativeType;
use JsonSerializable;

class Airport implements JsonSerializable{
    public function __construct(
        protected ?int $id = null,
        protected ?string $airportName = null
    ) {

    }

    public function jsonSerialize(): array {
        return [
            'ID' => $this->id,
            'Airport_name' => $this->airportName
        ];
    }

    public static function createForAllFlights(string $airportName){
        return new static(airportName: $airportName );
    }
}