<?php
namespace App\Http\Controllers\saft\Payments;

class Payment {

    public $PaymentRefNo = "t";
    public $Period = "1";
    public $TransactionDate = "2004-03-28";
    public $PaymentType = "RC";
    public $Description = "Recibo";
    public $SystemID = "2";
    public $DocumentStatus;
    public $PaymentMethod;
    public $SourceID = "string";
    public $SystemEntryDate = "1990-09-27T22:39:50.06";
    public $CustomerID = "string";
    public $Line = array();
    public $DocumentTotals;
   // public $WithholdingTax;

    function __construct() {
        $this->DocumentStatus = new DocumentStatus();
        $this->PaymentMethod = new PaymentMethod();
        $this->DocumentTotals = new DocumentTotals();
       // $this->WithholdingTax = new WithholdingTax();

    }
    
    function getPaymentRefNo() {
        return $this->PaymentRefNo;
    }

    function getPeriod() {
        return $this->Period;
    }

    function getTransactionDate() {
        return $this->TransactionDate;
    }

    function getPaymentType() {
        return $this->PaymentType;
    }

    function getDescription() {
        return $this->Description;
    }

    function getSystemID() {
        return $this->SystemID;
    }

    function getDocumentStatus() {
        return $this->DocumentStatus;
    }

    function getPaymentMethod() {
        return $this->PaymentMethod;
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

    function getWithholdingTax() {
        return $this->WithholdingTax;
    }

    function setPaymentRefNo($PaymentRefNo) {
        $this->PaymentRefNo = $PaymentRefNo;
    }

    function setPeriod($Period) {
        $this->Period = $Period;
    }

    function setTransactionDate($TransactionDate) {
        $this->TransactionDate = $TransactionDate;
    }

    function setPaymentType($PaymentType) {
        $this->PaymentType = $PaymentType;
    }

    function setDescription($Description) {
        $this->Description = $Description;
    }

    function setSystemID($SystemID) {
        $this->SystemID = $SystemID;
    }

    function setDocumentStatus($DocumentStatus) {
        $this->DocumentStatus = $DocumentStatus;
    }

    function setPaymentMethod($PaymentMethod) {
        $this->PaymentMethod = $PaymentMethod;
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

    function setWithholdingTax($WithholdingTax) {
        $this->WithholdingTax = $WithholdingTax;
    }
}

class DocumentStatus {

    public $PaymentStatus = "N";
    public $PaymentStatusDate = "2019-05-03";
    public $SourceID = "1";
    public $SourcePayment = "P";

    function __construct() {
        
    }
    function getPaymentStatus() {
        return $this->PaymentStatus;
    }

    function getPaymentStatusDate() {
        return $this->PaymentStatusDate;
    }

    function getSourceID() {
        return $this->SourceID;
    }

    function getSourcePayment() {
        return $this->SourcePayment;
    }

    function setPaymentStatus($PaymentStatus) {
        $this->PaymentStatus = $PaymentStatus;
    }

    function setPaymentStatusDate($PaymentStatusDate) {
        $this->PaymentStatusDate = $PaymentStatusDate;
    }

    function setSourceID($SourceID) {
        $this->SourceID = $SourceID;
    }

    function setSourcePayment($SourcePayment) {
        $this->SourcePayment = $SourcePayment;
    }
    
}

class PaymentMethod {

    public $PaymentMechanism = "CC";
    public $PaymentAmount = "5883330.2349058";
    public $PaymentDate = "1989-03-11";

    function __construct() {
        
    }
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

class DocumentTotals {

    public $TaxPayable = "0.00";
    public $NetTotal = "0.00";
    public $GrossTotal = "0.00";

    function __construct() {
        
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

    function setTaxPayable($TaxPayable) {
        $this->TaxPayable = $TaxPayable;
    }

    function setNetTotal($NetTotal) {
        $this->NetTotal = $NetTotal;
    }

    function setGrossTotal($GrossTotal) {
        $this->GrossTotal = $GrossTotal;
    }   
}

class Line
{

    public $LineNumber = "3467";
    public $SourceDocumentID;
    public $CreditAmount = "32250.00";

    function __construct()
    {
      $this->SourceDocumentID = new SourceDocumentID();
    }
    
    function getLineNumber() {
        return $this->LineNumber;
    }

    function getSourceDocumentID() {
        return $this->SourceDocumentID;
    }

    function getCreditAmount() {
        return $this->CreditAmount;
    }

    function setLineNumber($LineNumber) {
        $this->LineNumber = $LineNumber;
    }

    function setSourceDocumentID($SourceDocumentID) {
        $this->SourceDocumentID = $SourceDocumentID;
    }

    function setCreditAmount($CreditAmount) {
        $this->CreditAmount = $CreditAmount;
    }

}

class SourceDocumentID {

    public $OriginatingON = "string";
    public $InvoiceDate = "2005-04-01";
    public $Description = "t";
    
    
    function getOriginatingON() {
        return $this->OriginatingON;
    }

    function getInvoiceDate() {
        return $this->InvoiceDate;
    }

    function getDescription() {
        return $this->Description;
    }

    function setOriginatingON($OriginatingON) {
        $this->OriginatingON = $OriginatingON;
    }

    function setInvoiceDate($InvoiceDate) {
        $this->InvoiceDate = $InvoiceDate;
    }

    function setDescription($Description) {
        $this->Description = $Description;
    }    
    
}


class WithholdingTax
{

    public $WithholdingTaxType = "IRT";
    public $WithholdingTaxDescription = "Aplicação da Retenção";
    public $WithholdingTaxAmount = "0.00";
    
    
    function getWithholdingTaxType() {
        return $this->WithholdingTaxType;
    }

    function getWithholdingTaxDescription() {
        return $this->WithholdingTaxDescription;
    }

    function getWithholdingTaxAmount() {
        return $this->WithholdingTaxAmount;
    }

    function setWithholdingTaxType($WithholdingTaxType) {
        $this->WithholdingTaxType = $WithholdingTaxType;
    }

    function setWithholdingTaxDescription($WithholdingTaxDescription) {
        $this->WithholdingTaxDescription = $WithholdingTaxDescription;
    }

    function setWithholdingTaxAmount($WithholdingTaxAmount) {
        $this->WithholdingTaxAmount = $WithholdingTaxAmount;
    }
}

