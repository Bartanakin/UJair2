<?php

namespace App\Controllers\PlannerAppControllers;

use App\C\Controller;
use App\Interfaces\SettlementInterfaces\SettlementFinder;
use App\View;
use App\ViewPaths;

class SettlementController extends Controller
{
    protected array $payments = [];

    public function __construct(protected SettlementFinder $finder)
    {

    }

    public function settlementsPage(): View {
        try{
            array_merge($this -> payments, $this -> finder -> findSalaries());
            array_merge($this -> payments, $this -> finder -> findAirplanesLeasing());
            array_merge($this -> payments, $this -> finder -> ticketsPayment());
        }catch( \PDOException $e ){
            // TODO
        }

        return View::make(ViewPaths::SETTLEMENTS_PAGE, ['payments' => $this -> payments, 'warning' => ""]);
    }
}