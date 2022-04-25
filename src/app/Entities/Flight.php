<?php

namespace App\Entities;

use App\Model;
use DateTime;
use JsonSerializable;

class Flight implements JsonSerializable {
    public function __construct(protected ?int $id, protected ?DateTime $dateOfDeparture) {

    }

    public function jsonSerialize(): mixed {
        return [
            'ID' => $this->id,
            'DateTimeOfDeparture' => $this->dateOfDeparture->format(Model::$dateFormat)
        ];
    }
}