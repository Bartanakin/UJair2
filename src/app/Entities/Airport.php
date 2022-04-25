<?php

namespace App\Entities;

use JetBrains\PhpStorm\Internal\TentativeType;
use JsonSerializable;

class Airport implements JsonSerializable{
    public function __construct(protected int $id, protected string $airportName) {

    }

    public function jsonSerialize(): array {
        return [
            'ID' => $this->id,
            'Airport_name' => $this->airportName
        ];
    }
}