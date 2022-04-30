<?php

namespace Tests\Unit\Controllers;

use App\Controllers\PlannerAppControllers\PlannerLoginController;
use App\Exceptions\IncorrectLoginException;
use App\Interfaces\FindAllFlights;
use App\Interfaces\PlannerLoginInterface;
use App\Models\FindAllFlightsImpl;
use App\Models\PlannerLoginImpl;

class PlannerLoginControllerTest extends \PHPUnit\Framework\TestCase
{
    private PlannerLoginController $plannerLoginController;
    private $plannerLoginMock;
    private $findAllFlightsMock;
    protected function setUp(): void
    {
        parent::setUp();
        $this -> plannerLoginMock = $this->createMock(PlannerLoginImpl::class);
        $this -> findAllFlightsMock = $this->createMock(FindAllFlightsImpl::class);

        $this -> plannerLoginController = new PlannerLoginController(
            $this -> plannerLoginMock,
            $this -> findAllFlightsMock
        );
    }

    /** @test */
    public function shows_incorrect_login_message(){
        $this -> plannerLoginMock -> method('login') -> willThrowException(new IncorrectLoginException());
        $_POST["login"] = 'login';
        $_POST["password"] = 'password';
    }
}