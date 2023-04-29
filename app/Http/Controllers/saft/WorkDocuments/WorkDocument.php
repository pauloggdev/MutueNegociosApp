<?php

namespace App\Http\Controllers\saft\WorkDocuments;


class WorkDocument
{

    public $DocumentNumber = "2NFa 1";
    public $DocumentStatus;
    public $Hash = "J9NYlNNLMU0c/JeH5fCLhtjSsq3sdc5xmzd4QILjw3MN8UGHLyOoslGFmhK0fO1nbLengUbnPecBOETcG6r6FPb2jp2HXoyDtmsXFTCPsndN7gTLvr93/l4jBF4J8MDXqnH+ZBaoGsIPNB7GB6lAs4nrC8nmSXEl7Koxu9rIT4E=";
    public $HashControl = "1";
    public $Period = "5";
    public $WorkDate = "2007-01-24";
    public $WorkType = "Factura";
    public $SourceID = "Operador Demostração";
    public $SystemEntryDate = "2007-01-24T15:37:50";
    //public $TransactionID = "";
    public $CustomerID = "123456789";
    public $Line = array();
    public $DocumentTotals;

    function __construct()
    {
        $this->DocumentTotals = new DocumentTotals();
        $this->DocumentStatus = new DocumentStatus();
    }
    function getDocumentNumber() {
        return $this->DocumentNumber;
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

    function getWorkDate() {
        return $this->WorkDate;
    }

    function getWorkType() {
        return $this->WorkType;
    }

    function getSourceID() {
        return $this->SourceID;
    }

    function getSystemEntryDate() {
        return $this->SystemEntryDate;
    }

    function getTransactionID() {
        return $this->TransactionID;
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

    function setDocumentNumber($DocumentNumber) {
        $this->DocumentNumber = $DocumentNumber;
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

    function setWorkDate($WorkDate) {
        $this->WorkDate = $WorkDate;
    }

    function setWorkType($WorkType) {
        $this->WorkType = $WorkType;
    }

    function setSourceID($SourceID) {
        $this->SourceID = $SourceID;
    }

    function setSystemEntryDate($SystemEntryDate) {
        $this->SystemEntryDate = $SystemEntryDate;
    }

    function setTransactionID($TransactionID) {
        $this->TransactionID = $TransactionID;
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


class DocumentTotals
{

    public $TaxPayable = "128.64";
    public $NetTotal = "612.59";
    public $GrossTotal = "741.23";
    
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
class DocumentStatus
{

    public $WorkStatus = "N";
    public $WorkStatusDate = "2019-05-03T09:21:27";
    public $Reason = "";
    public $SourceID = "1";
    public $SourceBilling = "P";

    function __construct()
    {
    }
    
    function getWorkStatus() {
        return $this->WorkStatus;
    }

    function getWorkStatusDate() {
        return $this->WorkStatusDate;
    }

    function getReason() {
        return $this->Reason;
    }

    function getSourceID() {
        return $this->SourceID;
    }

    function getSourceBilling() {
        return $this->SourceBilling;
    }

    function setWorkStatus($WorkStatus) {
        $this->WorkStatus = $WorkStatus;
    }

    function setWorkStatusDate($WorkStatusDate) {
        $this->WorkStatusDate = $WorkStatusDate;
    }

    function setReason($Reason) {
        $this->Reason = $Reason;
    }

    function setSourceID($SourceID) {
        $this->SourceID = $SourceID;
    }

    function setSourceBilling($SourceBilling) {
        $this->SourceBilling = $SourceBilling;
    }


}

class Payment
{

    private $PaymentMechanism = "CC";
    private $PaymentAmount = "0.00";
    private $PaymentDate = "";
    
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


class Line
{

    public $LineNumber = "1";
    public $ProductCode = "PR LJ5P";
    public $ProductDescription = "Impressora Laser Jet 5P";
    public $Quantity = "1";
    public $UnitOfMeasure = "Unid";
    public $UnitPrice = "482.59";
    public $TaxPointDate = "2007-01-24";
    public $Description = "bom";
    public $CreditAmount = "0.00";
    public $Tax;
    public $TaxExemptionReason = "";
    public $TaxExemptionCode = "";
    public $SettlementAmount = "0";

    function __construct()
    {
        $this->Tax = new Tax();
    }
    
    function getLineNumber() {
        return $this->LineNumber;
    }

    function getProductCode() {
        return $this->ProductCode;
    }

    function getProductDescription() {
        return $this->ProductDescription;
    }

    function getQuantity() {
        return $this->Quantity;
    }

    function getUnitOfMeasure() {
        return $this->UnitOfMeasure;
    }

    function getUnitPrice() {
        return $this->UnitPrice;
    }

    function getTaxPointDate() {
        return $this->TaxPointDate;
    }

    function getDescription() {
        return $this->Description;
    }

    function getCreditAmount() {
        return $this->CreditAmount;
    }

    function getTax() {
        return $this->Tax;
    }

    function getSettlementAmount() {
        return $this->SettlementAmount;
    }

    function setLineNumber($LineNumber) {
        $this->LineNumber = $LineNumber;
    }

    function setProductCode($ProductCode) {
        $this->ProductCode = $ProductCode;
    }

    function setProductDescription($ProductDescription) {
        $this->ProductDescription = $ProductDescription;
    }

    function setQuantity($Quantity) {
        $this->Quantity = $Quantity;
    }

    function setUnitOfMeasure($UnitOfMeasure) {
        $this->UnitOfMeasure = $UnitOfMeasure;
    }

    function setUnitPrice($UnitPrice) {
        $this->UnitPrice = $UnitPrice;
    }

    function setTaxPointDate($TaxPointDate) {
        $this->TaxPointDate = $TaxPointDate;
    }

    function setDescription($Description) {
        $this->Description = $Description;
    }

    function setCreditAmount($CreditAmount) {
        $this->CreditAmount = $CreditAmount;
    }
    function getTaxExemptionReason() {
        return $this->TaxExemptionReason;
    }

    function getTaxExemptionCode() {
        return $this->TaxExemptionCode;
    }
    function setTaxExemptionReason($TaxExemptionReason) {
        $this->TaxExemptionReason = $TaxExemptionReason;
    }

    function setTaxExemptionCode($TaxExemptionCode) {
        $this->TaxExemptionCode = $TaxExemptionCode;
    }

    function setTax($Tax) {
        $this->Tax = $Tax;
    }

    function setSettlementAmount($SettlementAmount) {
        $this->SettlementAmount = $SettlementAmount;
    }


}

class Tax
{

    public $TaxType = "IVA";
    public $TaxCountryRegion = "AO";
    public $TaxCode = "26";
    public $TaxPercentage = "14";
    
    function getTaxType() {
        return $this->TaxType;
    }

    function getTaxCountryRegion() {
        return $this->TaxCountryRegion;
    }

    function getTaxCode() {
        return $this->TaxCode;
    }

    function getTaxPercentage() {
        return $this->TaxPercentage;
    }

    function setTaxType($TaxType) {
        $this->TaxType = $TaxType;
    }

    function setTaxCountryRegion($TaxCountryRegion) {
        $this->TaxCountryRegion = $TaxCountryRegion;
    }

    function setTaxCode($TaxCode) {
        $this->TaxCode = $TaxCode;
    }

    function setTaxPercentage($TaxPercentage) {
        $this->TaxPercentage = $TaxPercentage;
    }

}
