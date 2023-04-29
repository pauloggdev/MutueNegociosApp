<?php
namespace App\Http\Controllers\saft;

class Product {

    public $ProductType = "P";
    public $ProductCode = "279";
    //public $ProductGroup = "N/A";
    public $ProductDescription = "PRODUTO AO 1";
    public $ProductNumberCode = "1";

    function __construct() {
        
    }
    
    function getProductType() {
        return $this->ProductType;
    }

    function getProductCode() {
        return $this->ProductCode;
    }

    function getProductGroup() {
        return $this->ProductGroup;
    }

    function getProductDescription() {
        return $this->ProductDescription;
    }

    function getProductNumberCode() {
        return $this->ProductNumberCode;
    }

    function setProductType($ProductType) {
        $this->ProductType = $ProductType;
    }

    function setProductCode($ProductCode) {
        $this->ProductCode = $ProductCode;
    }

    function setProductGroup($ProductGroup) {
        $this->ProductGroup = $ProductGroup;
    }

    function setProductDescription($ProductDescription) {
        $this->ProductDescription = $ProductDescription;
    }

    function setProductNumberCode($ProductNumberCode) {
        $this->ProductNumberCode = $ProductNumberCode;
    }
}
