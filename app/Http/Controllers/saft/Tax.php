
<?php


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
