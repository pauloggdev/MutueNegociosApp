<?php

namespace App\Http\Controllers\saft\LineNotaCredito;


class Line
{

    public $LineNumber = "1";
    public $ProductCode = "PR LJ5P";
    public $ProductDescription = "Impressora Laser Jet 5P";
    public $Quantity = "1";
    public $UnitOfMeasure = "Unid";
    public $UnitPrice = "482.59";
    public $TaxPointDate = "2007-01-24";
    public $References;
    public $Description = "bom";
    public $DebitAmount = "0.00";
    public $CreditAmount = "0.00";
    public $Tax;
    public $TaxExemptionReason = "";
    public $TaxExemptionCode = "";
    public $SettlementAmount = "0";

    function __construct()
    {
        $this->References = new Referenes();
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

    function getTaxExemptionReason() {
        return $this->TaxExemptionReason;
    }

    function getTaxExemptionCode() {
        return $this->TaxExemptionCode;
    }
    function getReferences() {
        return $this->References;
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
    function setDebitAmount($DebitAmount) {
        $this->DebitAmount = $DebitAmount;
    }
    function getDebitAmount() {
        return $this->CreditAmount;
    }
    function setTax($Tax) {
        $this->Tax = $Tax;
    }

    function setTaxExemptionReason($TaxExemptionReason) {
        $this->TaxExemptionReason = $TaxExemptionReason;
    }

    function setTaxExemptionCode($TaxExemptionCode) {
        $this->TaxExemptionCode = $TaxExemptionCode;
    }

    function setSettlementAmount($SettlementAmount) {
        $this->SettlementAmount = $SettlementAmount;
    }
    function setReferences($References) {
        $this->References = $References;
    }
}
class Referenes{

    public $Reference = "FR AGT2020/5";
    public $Reason = "Description Nota Credito";

    function getReference() {
        return $this->Reference;
    }
    function getReason() {
        return $this->Reason;
    }
    function setReference($Reference) {
        $this->Reference = $Reference;
    }
    function setReason($Reason) {
        $this->Reason = $Reason;
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
