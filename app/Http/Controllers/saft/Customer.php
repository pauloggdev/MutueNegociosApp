<?php
namespace App\Http\Controllers\saft;

class Customer
{

    public $CustomerID = "24";
    public $AccountID = "Desconhecido";
    public $CustomerTaxID = "Consumidor final";
    public $CompanyName = "Cliente AO 5 SN";
    public $BillingAddress;
    public $SelfBillingIndicator = "0";


    function __construct()
    {
        $this->BillingAddress = new BillingAddress();
    }
    function getCustomerID() {
        return $this->CustomerID;
    }

    function getAccountID() {
        return $this->AccountID;
    }

    function getCustomerTaxID() {
        return $this->CustomerTaxID;
    }

    function getCompanyName() {
        return $this->CompanyName;
    }

    function getBillingAddress() {
        return $this->BillingAddress;
    }

    function getSelfBillingIndicator() {
        return $this->SelfBillingIndicator;
    }

    function setCustomerID($CustomerID) {
        $this->CustomerID = $CustomerID;
    }

    function setAccountID($AccountID) {
        $this->AccountID = $AccountID;
    }

    function setCustomerTaxID($CustomerTaxID) {
        $this->CustomerTaxID = $CustomerTaxID;
    }

    function setCompanyName($CompanyName) {
        $this->CompanyName = $CompanyName;
    }

    function setBillingAddress($BillingAddress) {
        $this->BillingAddress = $BillingAddress;
    }

    function setSelfBillingIndicator($SelfBillingIndicator) {
        $this->SelfBillingIndicator = $SelfBillingIndicator;
    }



    
}

class BillingAddress
{

    public $AddressDetail = "Av. Deolinda Rodrigues, 123";
    public $City = "Luanda";
    public $PostalCode = "*";
    public $Country = "AO";

    function __construct()
    {
    }
    
    function getAddressDetail() {
        return $this->AddressDetail;
    }

    function getCity() {
        return $this->City;
    }

    function getPostalCode() {
        return $this->PostalCode;
    }

    function getCountry() {
        return $this->Country;
    }

    function setAddressDetail($AddressDetail) {
        $this->AddressDetail = $AddressDetail;
    }

    function setCity($City) {
        $this->City = $City;
    }

    function setPostalCode($PostalCode) {
        $this->PostalCode = $PostalCode;
    }

    function setCountry($Country) {
        $this->Country = $Country;
    }



    
}
