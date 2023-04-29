<?php

namespace App\Http\Controllers\saft\Payments;

use App\Http\Controllers\saft\Payments\Payment;


class Payments
{

    public $NumberOfEntries = "0";
    public $TotalDebit = "0.00";
    public $TotalCredit = "0.00";
    public $Payment = array();


    function __construct()
    {
        //$this->Payment = new Payment;
    }
    
    function getNumberOfEntries() {
        return $this->NumberOfEntries;
    }

    function getTotalDebit() {
        return $this->TotalDebit;
    }

    function getTotalCredit() {
        return $this->TotalCredit;
    }

    function getPayment() {
        return $this->Payment;
    }

    function setNumberOfEntries($NumberOfEntries) {
        $this->NumberOfEntries = $NumberOfEntries;
    }

    function setTotalDebit($TotalDebit) {
        $this->TotalDebit = $TotalDebit;
    }

    function setTotalCredit($TotalCredit) {
        $this->TotalCredit = $TotalCredit;
    }

    function setPayment($Payment) {
        $this->Payment = $Payment;
    }

}
