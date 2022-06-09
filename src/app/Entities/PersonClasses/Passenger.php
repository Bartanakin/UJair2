<?php

namespace App\Entities\PersonClasses;

class Passenger extends Person
{
    protected function __construct(
        ?int $id = null,
        ?string $firstName = null,
        ?string $lastName = null,
        protected ?string $password = null,
        protected ?string $login = null,
        protected ?int $countryID = null
    ) {
        parent::__construct($id, $firstName, $lastName);
    }

    public static function createPassengerForRegistration(string $firstName,
                                                          string $lastName,
                                                          string $password,
                                                          string $login,
                                                          int $countryID) {
        return new static(
            firstName: $firstName,
            lastName: $lastName,
            password: $password,
            login: $login,
            countryID: $countryID
        );
    }

    /**
     * @inheritDoc
     */
    public function jsonSerialize(): mixed
    {
        return [
            'ID' => $this -> ID,
            'firstName' => $this -> firstName,
            'lastName' => $this -> surname,
            'password' => $this -> password,
            'login' => $this -> login,
            'country' => $this -> countryID
        ];
    }
}