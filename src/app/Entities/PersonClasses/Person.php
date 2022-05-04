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
}