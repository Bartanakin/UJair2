<?php

namespace Tests\Unit\Models;


use App\Models\FindCrewForFlightImpl;

class FindCrewForFlightImplTest extends ModelTestBaseClass
{
    private FindCrewForFlightImpl $findCrewForFlightImpl;
    protected function setUp(): void
    {
        parent::setUp();
        $this -> findCrewForFlightImpl = new FindCrewForFlightImpl(
            $this ->dataBaseConnectionMock
        );
    }

    /** @test */
    public function checks_if_proper_object_is_returned(){

    }
}