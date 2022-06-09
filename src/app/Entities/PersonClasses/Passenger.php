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

    /**
     * @return string|null
     */
    public function getPassword(): ?string
    {
        return $this->password;
    }

    /**
     * @return string|null
     */
    public function getLogin(): ?string
    {
        return $this->login;
    }

    /**
     * @return int|null
     */
    public function getCountryID(): ?int
    {
        return $this->countryID;
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