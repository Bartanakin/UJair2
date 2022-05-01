<?php

namespace Tests\Unit\Controllers;

use App\Controllers\PlannerAppControllers\PlannerLoginController;
use App\Entities\Flight;
use App\Exceptions\IncorrectLoginException;
use App\Exceptions\IncorrectPasswordException;
use App\Interfaces\FindAllFlights;
use App\Interfaces\PlannerLoginInterface;
use App\Models\FindAllFlightsImpl;
use App\Models\PlannerLoginImpl;
use App\View;
use App\ViewPaths;

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

        $expected = View::make(ViewPaths::HOME_PAGE,['serverMessage' => "Incorrect login"]);

        $this -> assertEquals($expected,$this -> plannerLoginController -> login());
    }

    /** @test */
    public function shows_incorrect_password_message(){
        $this -> plannerLoginMock -> method('login') -> willThrowException(new IncorrectPasswordException());
        $_POST["login"] = 'login';
        $_POST["password"] = 'password';

        $expected = View::make(ViewPaths::HOME_PAGE,['serverMessage' => "Incorrect password"]);

        $this -> assertEquals($expected,$this -> plannerLoginController -> login());
    }

    /** @test */
    public function redirects_to_all_flights_page(){
        $this -> findAllFlightsMock -> method('findAllFlights') -> willReturn(array(new Flight()));
        $_POST["login"] = 'login';
        $_POST["password"] = 'password';

        $expected = View::make(ViewPaths::ALL_FLIGHTS_PAGE,['allFLights' => array(new Flight())]);

        $this -> assertEquals($expected,$this -> plannerLoginController -> login());
    }

    /** @test */
    public function redirect_to_bad_request_page(){
        unset($_SESSION['logged']);
        unset($_POST["login"], $_POST["password"]);
        $expected = View::make(ViewPaths::BAD_REQUEST);

        $this -> assertEquals($expected,$this -> plannerLoginController -> login());
    }

    /** @test */
    public function redirect_to_all_flights_if_logged(){
        $_SESSION['logged'] = true;
        $this -> findAllFlightsMock -> method('findAllFlights') -> willReturn(array(new Flight()));

        $expected = View::make(ViewPaths::ALL_FLIGHTS_PAGE,['allFLights' => array(new Flight())]);


        $this -> assertEquals($expected,$this -> plannerLoginController -> login());

    }
}