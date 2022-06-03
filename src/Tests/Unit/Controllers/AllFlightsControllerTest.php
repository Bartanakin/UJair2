<?php

namespace Tests\Unit\Controllers;

use App\Controllers\PlannerAppControllers\AllFlightsController;
use App\Entities\Flight;
use App\Exceptions\IncorrectLoginException;
use App\Interfaces\FindAllFlights;
use App\Interfaces\FindCrewForFlight;
use App\Interfaces\PlannerLoginInterface;
use App\View;
use App\ViewPaths;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

class AllFlightsControllerTest extends TestCase
{
    private AllFlightsController $allFlightsController;
    private MockObject $loginService;
    private MockObject $findAllFlights;

    protected function setUp(): void
    {
        parent::setUp();
        $this -> findAllFlights = $this->createMock(FindAllFlights::class);
        $this -> loginService = $this->createMock(PlannerLoginInterface::class);
        $this -> allFlightsController = new AllFlightsController($this -> loginService,$this -> findAllFlights);;
    }



}