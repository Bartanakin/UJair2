<?php

namespace Tests\Unit\Controllers;

use App\Controllers\PlannerAppControllers\AllFlightsController;
use App\Entities\Flight;
use App\Interfaces\FindCrewForFlight;
use App\View;
use App\ViewPaths;
use PHPUnit\Framework\TestCase;

class AllFlightsControllerTest extends TestCase
{
    private AllFlightsController $allFlightsController;
    private FindCrewForFlight $findCrewForFlight;

    protected function setUp(): void
    {
        parent::setUp();
        $this -> findCrewForFlight = $this->createMock(FindCrewForFlight::class);
        $this -> allFlightsController = new AllFlightsController($this -> findCrewForFlight);;
    }

    /** @test */
    public function check_redirect_to_create_flight_page_when_adding_flight(){

        $result =  $this -> allFlightsController -> addFlight();
        $this -> assertEquals(ViewPaths::EDIT_FLIGHT_PAGE,$result -> getPath());
    }

    /** @test */
    public function check_redirect_to_edit_crew_page(){

        $_POST['flightID'] = 4;
        $result = $this -> allFlightsController -> editCrew();

        $this -> assertTrue(isset($_SESSION['editedFlight']));
        $this -> assertEquals($_SESSION['editedFlight'] -> ID,$_POST['flightID']);

        $this -> assertEquals(ViewPaths::EDIT_CREW_PAGE,$result -> getPath());
        $this -> assertInstanceOf(Flight::class,$result -> getParams()['editedFlight']);
    }

    /** @test */
    public function check_redirect_settlements_page(){

        $this -> allFlightsController -> showSettlements();

        // TODO add URI
        $this -> assertContains("Location: ",headers_list());

    }


}