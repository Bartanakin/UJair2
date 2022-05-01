<?php

namespace App\Models\PassengerRegistrationModels;

use App\DataBaseConnection;
use App\Entities\Country;

class CountriesLoaderImpl extends \App\Model implements \App\Interfaces\PassengerRegistrationInterfaces\CountriesLoader
{
    public function __construct( DataBaseConnection $dataBaseConnection,protected array $countries = []){
        parent::__construct($dataBaseConnection);
    }
    function run(): array
    {
        $query = 'SELECT * FROM Countries;';
        $statement = $this -> getDBConnection() -> prepare($query);
        $statement -> execute();
        while($data = $statement -> fetch()) {
            $this -> countries[] = Country::createForCountryLoader($data['ID'], $data['CountryName']);
        }
        return $this -> countries;
    }
}