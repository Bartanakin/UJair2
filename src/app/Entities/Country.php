<?php

namespace App\Entities;

use JetBrains\PhpStorm\Internal\TentativeType;

class Country implements \JsonSerializable
{
    protected function __construct(
        protected ?int $id = null,
        protected ?string $name = null
    ) {

    }

    public static function createForCountryLoader(int $id, string $name) {
        return new static(
            id: $id,
            name: $name
        );
    }
    /**
     * @inheritDoc
     */
    public function jsonSerialize(): mixed
    {
        return [
            'ID' => $this -> id,
            'countryName' => $this -> name
        ];
    }
}