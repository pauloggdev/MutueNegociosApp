<?php
namespace App\Http\Controllers\saft;

class TaxTableEntry {

    public $TaxType = "IVA";
    public $TaxCountryRegion = "AO";
    public $TaxCode = "NOR";
    public $Description = "Normal";
    public $TaxPercentage = "14";

    //private $TaxAmount = "0";

    function __construct()
    {
        
    }
    function getTaxType() {
        return $this->TaxType;
    }

    function getTaxCountryRegion() {
        return $this->TaxCountryRegion;
    }

    function getTaxCode() {
        return $this->TaxCode;
    }

    function getDescription() {
        return $this->Description;
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

    function setDescription($Description) {
        $this->Description = $Description;
    }

    function setTaxPercentage($TaxPercentage) {
        $this->TaxPercentage = $TaxPercentage;
    }
}
