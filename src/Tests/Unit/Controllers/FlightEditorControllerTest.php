<?php

namespace Tests\Unit\Controllers;

use App\Controllers\PlannerAppControllers\AllFlightsController;
use PHPUnit\Framework\TestCase;

class FlightEditorControllerTest extends TestCase
{

    private AllFlightsController $allFlightsController;

    protected function setUp(): void
    {
        parent::setUp();
        $this -> allFlightsController = new AllFlightsController();
    }

    /** @test */
    public function it_checks_exception_should_return_array_of_airplanes(){

    }
}