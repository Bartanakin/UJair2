<?php

namespace Tests\Unit\Models;

use App\Models\FlightEditorModels\FindFlightDataImpl;

class FindFlightDataImplTest extends ModelTestBaseClass
{

    private FindFlightDataImpl $findFlightDataImplTest;
    protected function setUp(): void
    {
        parent::setUp();
        $this -> findFlightDataImplTest = new FindFlightDataImpl( $this -> dataBaseConnectionMock );
    }

}