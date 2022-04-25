<?php

namespace App\Entities;

use DateTime;
use JetBrains\PhpStorm\Internal\TentativeType;
use JsonSerializable;

class Flight implements JsonSerializable {
    public function __construct(protected ?int $id, protected ?DateTime $dateOfDeparture) {

    }

    public function jsonSerialize(): mixed {
        return [
            'ID' => $this->id,
            'DateTimeOfDeparture' => $this->dateOfDeparture->format('Y-m-d H:i:s')
        ];
    }
}