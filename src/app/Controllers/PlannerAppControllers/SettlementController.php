<?php

namespace App\Controllers\PlannerAppControllers;

use App\C\Controller;
use App\Entities\SettlementClasses\PaymentList;
use App\Interfaces\SettlementInterfaces\SettlementFinder;
use App\View;
use App\ViewPaths;

class SettlementController extends Controller
{
    protected PaymentList $payments;

    public function __construct(protected SettlementFinder $finder)
    {
        $this -> payments = new PaymentList();
    }

    public function settlementsPage(): View {
        try{
            $this ->payments -> addPayments( $this -> finder -> findSalaries());
            $this ->payments -> addPayments( $this -> finder -> findAirplanesLeasing());
            $this ->payments -> addPayments( $this -> finder -> ticketsPayment());
        }catch( \PDOException $e ){
            // TODO
        }
        return View::make(ViewPaths::SETTLEMENTS_PAGE, ['payments' => $this -> payments, 'warning' => ""]);
    }
}