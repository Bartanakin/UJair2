<?php

namespace App\Entities\SettlementClasses;

class PaymentList
{
    /** @var $payments Payment[] */
    protected array $payments = [];

    /**
     * @return array
     */
    public function getPayments(): array
    {
        return $this->payments;
    }

    public function getSum(): float {
        $sum = 0;
        foreach ( $this -> payments as $payment ){
            $sum += $payment -> getValue();
        }
        return $sum;
    }

    public function addPayments(array $added): void {
        $this -> payments = array_merge($this -> payments, $added);
        usort($this -> payments, fn($x,$y) =>  (int)($x -> getDate() < $y -> getDate()) );
    }
}