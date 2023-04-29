<?php

namespace App\Http\Controllers\saft;

class Invoice
{
    public $InvoiceNo = "2NFa 1";
    public $DocumentStatus;
    public $Hash = "J9NYlNNLMU0c/JeH5fCLhtjSsq3sdc5xmzd4QILjw3MN8UGHLyOoslGFmhK0fO1nbLengUbnPecBOETcG6r6FPb2jp2HXoyDtmsXFTCPsndN7gTLvr93/l4jBF4J8MDXqnH+ZBaoGsIPNB7GB6lAs4nrC8nmSXEl7Koxu9rIT4E=";
    public $HashControl = "1";
    public $Period = "5";
    public $InvoiceDate = "2007-01-24";
    public $InvoiceType = "Factura";
    public $SpecialRegimes;
    public $SourceID = "Operador Demostração";
    public $SystemEntryDate = "2007-01-24T15:37:50";
    public $CustomerID = "123456789";
    public $Line = array();
    public $DocumentTotals;

    function __construct()
    {
        $this->SpecialRegimes = new SpecialRegimes();
        $this->DocumentStatus = new DocumentStatus();
        $this->DocumentTotals = new DocumentTotals();
    }
    function getInvoiceNo() {
        return $this->InvoiceNo;
    }

    function getDocumentStatus() {
        return $this->DocumentStatus;
    }

    function getHash() {
        return $this->Hash;
    }

    function getHashControl() {
        return $this->HashControl;
    }

    function getPeriod() {
        return $this->Period;
    }

    function getInvoiceDate() {
        return $this->InvoiceDate;
    }

    function getInvoiceType() {
        return $this->InvoiceType;
    }

    function getSpecialRegimes() {
        return $this->SpecialRegimes;
    }

    function getSourceID() {
        return $this->SourceID;
    }

    function getSystemEntryDate() {
        return $this->SystemEntryDate;
    }

    function getCustomerID() {
        return $this->CustomerID;
    }

    function getLine() {
        return $this->Line;
    }

    function getDocumentTotals() {
        return $this->DocumentTotals;
    }

    function setInvoiceNo($InvoiceNo) {
        $this->InvoiceNo = $InvoiceNo;
    }

    function setDocumentStatus($DocumentStatus) {
        $this->DocumentStatus = $DocumentStatus;
    }

    function setHash($Hash) {
        $this->Hash = $Hash;
    }

    function setHashControl($HashControl) {
        $this->HashControl = $HashControl;
    }

    function setPeriod($Period) {
        $this->Period = $Period;
    }

    function setInvoiceDate($InvoiceDate) {
        $this->InvoiceDate = $InvoiceDate;
    }

    function setInvoiceType($InvoiceType) {
        $this->InvoiceType = $InvoiceType;
    }

    function setSpecialRegimes($SpecialRegimes) {
        $this->SpecialRegimes = $SpecialRegimes;
    }

    function setSourceID($SourceID) {
        $this->SourceID = $SourceID;
    }

    function setSystemEntryDate($SystemEntryDate) {
        $this->SystemEntryDate = $SystemEntryDate;
    }

    function setCustomerID($CustomerID) {
        $this->CustomerID = $CustomerID;
    }

    function setLine($Line) {
        $this->Line = $Line;
    }

    function setDocumentTotals($DocumentTotals) {
        $this->DocumentTotals = $DocumentTotals;
    }
}

class SpecialRegimes
{

    public $SelfBillingIndicator = "0";
    public $CashVATSchemeIndicator = "0";
    public $ThirdPartiesBillingIndicator = "0";

    function __construct()
    {
    }
    function getSelfBillingIndicator() {
        return $this->SelfBillingIndicator;
    }

    function getCashVATSchemeIndicator() {
        return $this->CashVATSchemeIndicator;
    }

    function getThirdPartiesBillingIndicator() {
        return $this->ThirdPartiesBillingIndicator;
    }

    function setSelfBillingIndicator($SelfBillingIndicator) {
        $this->SelfBillingIndicator = $SelfBillingIndicator;
    }

    function setCashVATSchemeIndicator($CashVATSchemeIndicator) {
        $this->CashVATSchemeIndicator = $CashVATSchemeIndicator;
    }

    function setThirdPartiesBillingIndicator($ThirdPartiesBillingIndicator) {
        $this->ThirdPartiesBillingIndicator = $ThirdPartiesBillingIndicator;
    }
}

class DocumentStatus
{

    public $InvoiceStatus = "N";
    public $InvoiceStatusDate = "2019-05-03T09:21:27";
    public $SourceID = "1";
    public $SourceBilling = "P";

    function __construct()
    {
    }
    function getInvoiceStatus() {
        return $this->InvoiceStatus;
    }

    function getInvoiceStatusDate() {
        return $this->InvoiceStatusDate;
    }

    function getSourceID() {
        return $this->SourceID;
    }

    function getSourceBilling() {
        return $this->SourceBilling;
    }

    function setInvoiceStatus($InvoiceStatus) {
        $this->InvoiceStatus = $InvoiceStatus;
    }

    function setInvoiceStatusDate($InvoiceStatusDate) {
        $this->InvoiceStatusDate = $InvoiceStatusDate;
    }

    function setSourceID($SourceID) {
        $this->SourceID = $SourceID;
    }

    function setSourceBilling($SourceBilling) {
        $this->SourceBilling = $SourceBilling;
    }
}
class DocumentTotals
{

    public $TaxPayable = "128.64";
    public $NetTotal = "612.59";
    public $GrossTotal = "741.23";
    public $Payment;

    function __construct()
    {
        $this->Payment = new Payment();
    }
    
    function getTaxPayable() {
        return $this->TaxPayable;
    }

    function getNetTotal() {
        return $this->NetTotal;
    }

    function getGrossTotal() {
        return $this->GrossTotal;
    }

    function getPayment() {
        return $this->Payment;
    }

    function setTaxPayable($TaxPayable) {
        $this->TaxPayable = $TaxPayable;
    }

    function setNetTotal($NetTotal) {
        $this->NetTotal = $NetTotal;
    }

    function setGrossTotal($GrossTotal) {
        $this->GrossTotal = $GrossTotal;
    }

    function setPayment($Payment) {
        $this->Payment = $Payment;
    }    
}
class Payment
{

    public $PaymentMechanism = "CC";
    public $PaymentAmount = "0.00";
    public $PaymentDate = "2020-07-08";
    
    function getPaymentMechanism() {
        return $this->PaymentMechanism;
    }

    function getPaymentAmount() {
        return $this->PaymentAmount;
    }

    function getPaymentDate() {
        return $this->PaymentDate;
    }

    function setPaymentMechanism($PaymentMechanism) {
        $this->PaymentMechanism = $PaymentMechanism;
    }

    function setPaymentAmount($PaymentAmount) {
        $this->PaymentAmount = $PaymentAmount;
    }

    function setPaymentDate($PaymentDate) {
        $this->PaymentDate = $PaymentDate;
    }
}
