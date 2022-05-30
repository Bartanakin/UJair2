<?php

namespace App\Entities\PersonClasses;

abstract class Person
{
    protected function __construct(
        protected ?int $ID = null,
        protected ?string $firstName = null,
        protected ?string $surname = null
    )
    {
    }

    /**
     * @return int|null
     */
    public function getID(): ?int
    {
        return $this->ID;
    }

    /**
     * @return string|null
     */
    public function getFirstName(): ?string
    {
        return $this->firstName;
    }

    /**
     * @return string|null
     */
    public function getSurname(): ?string
    {
        return $this->surname;
    }
}