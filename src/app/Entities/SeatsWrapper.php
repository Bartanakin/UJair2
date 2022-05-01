<?php

namespace App\Entities;


class SeatsWrapper implements \JsonSerializable
{

    protected function __construct(protected array $seats) {

    }

    /**
     * @inheritDoc
     */

    public static function createForBookingTickets(array $seats) {
        return new static(
            seats: $seats
        );
    }

    public function jsonSerialize(): mixed
    {
        return [
            'seats' => $this->seats
        ];
    }
}