<?php

namespace App\Http\Controllers\saft;

use App\Http\Controllers\saft\Product;
use App\Http\Controllers\saft\Customer;
use App\Http\Controllers\saft\TaxTableEntry;
use App\Http\Controllers\saft\Invoice;
use App\Http\Controllers\saft\WorkDocuments\WorkDocument;
use App\Http\Controllers\saft\Payments\Payments;

class AuditFile
{

    public $Header;
    public $MasterFiles;
    public $SourceDocuments;

    function __construct()
    {
        $this->Header = new Header();
        $this->MasterFiles  = new MasterFiles();
        $this->SourceDocuments = new SourceDocuments();
    }
    function getHeader()
    {
        return $this->Header;
    }

    function getMasterFiles()
    {
        return $this->MasterFiles;
    }

    function getSourceDocuments()
    {
        return $this->SourceDocuments;
    }

    function setHeader($Header)
    {
        $this->Header = $Header;
    }

    function setMasterFiles($MasterFiles)
    {
        $this->MasterFiles = $MasterFiles;
    }

    function setSourceDocuments($SourceDocuments)
    {
        $this->SourceDocuments = $SourceDocuments;
    }
}


class Header
{

    public $AuditFileVersion = "1.01_01";
    public $CompanyID = "5417221951";
    public $TaxRegistrationNumber = "5183733";
    public $TaxAccountingBasis = "F";
    public $CompanyName = "Mutue";
    public $BusinessName = "EMPRESA DE DEMONSTRAÇÃO";
    public $CompanyAddress;
    public $FiscalYear = "2019";
    public $StartDate = "2019-03-01";
    public $EndDate = "2019-03-31";
    public $CurrencyCode = "AOA";
    public $DateCreated = "2019-04-08";
    public $TaxEntity = "Global";
    public $ProductCompanyTaxID = "AO503140600";
    public $SoftwareValidationNumber = "32/AGT/2019";
    public $ProductID = "Mutue-Negocio RAMOS SOFTWARE E FABRICA DE SOFTWARE";
    public $ProductVersion = "10.5.19";
    public $Telephone = "923292970-924484343";
    // public $Fax = "948100";
    public $Email = "geral@ao.primaverabss.com";
    // public $Website = "www.ao.primaverabss.com";

    function __construct()
    {
        $this->CompanyAddress = new CompanyAddress();
    }
    function getAuditFileVersion()
    {
        return $this->AuditFileVersion;
    }

    function getCompanyID()
    {
        return $this->CompanyID;
    }

    function getTaxRegistrationNumber()
    {
        return $this->TaxRegistrationNumber;
    }

    function getTaxAccountingBasis()
    {
        return $this->TaxAccountingBasis;
    }

    function getCompanyName()
    {
        return $this->CompanyName;
    }

    function getBusinessName()
    {
        return $this->BusinessName;
    }

    function getCompanyAddress()
    {
        return $this->CompanyAddress;
    }

    function getFiscalYear()
    {
        return $this->FiscalYear;
    }

    function getStartDate()
    {
        return $this->StartDate;
    }

    function getEndDate()
    {
        return $this->EndDate;
    }

    function getCurrencyCode()
    {
        return $this->CurrencyCode;
    }

    function getDateCreated()
    {
        return $this->DateCreated;
    }

    function getTaxEntity()
    {
        return $this->TaxEntity;
    }

    function getProductCompanyTaxID()
    {
        return $this->ProductCompanyTaxID;
    }

    function getSoftwareValidationNumber()
    {
        return $this->SoftwareValidationNumber;
    }

    function getProductID()
    {
        return $this->ProductID;
    }

    function getProductVersion()
    {
        return $this->ProductVersion;
    }

    function getTelephone()
    {
        return $this->Telephone;
    }

    function getFax()
    {
        return $this->Fax;
    }

    function getEmail()
    {
        return $this->Email;
    }

    function getWebsite()
    {
        return $this->Website;
    }

    function setAuditFileVersion($AuditFileVersion)
    {
        $this->AuditFileVersion = $AuditFileVersion;
    }

    function setCompanyID($CompanyID)
    {
        $this->CompanyID = $CompanyID;
    }

    function setTaxRegistrationNumber($TaxRegistrationNumber)
    {
        $this->TaxRegistrationNumber = $TaxRegistrationNumber;
    }

    function setTaxAccountingBasis($TaxAccountingBasis)
    {
        $this->TaxAccountingBasis = $TaxAccountingBasis;
    }

    function setCompanyName($CompanyName)
    {
        $this->CompanyName = $CompanyName;
    }

    function setBusinessName($BusinessName)
    {
        $this->BusinessName = $BusinessName;
    }

    function setCompanyAddress($CompanyAddress)
    {
        $this->CompanyAddress = $CompanyAddress;
    }

    function setFiscalYear($FiscalYear)
    {
        $this->FiscalYear = $FiscalYear;
    }

    function setStartDate($StartDate)
    {
        $this->StartDate = $StartDate;
    }

    function setEndDate($EndDate)
    {
        $this->EndDate = $EndDate;
    }

    function setCurrencyCode($CurrencyCode)
    {
        $this->CurrencyCode = $CurrencyCode;
    }

    function setDateCreated($DateCreated)
    {
        $this->DateCreated = $DateCreated;
    }

    function setTaxEntity($TaxEntity)
    {
        $this->TaxEntity = $TaxEntity;
    }

    function setProductCompanyTaxID($ProductCompanyTaxID)
    {
        $this->ProductCompanyTaxID = $ProductCompanyTaxID;
    }

    function setSoftwareValidationNumber($SoftwareValidationNumber)
    {
        $this->SoftwareValidationNumber = $SoftwareValidationNumber;
    }

    function setProductID($ProductID)
    {
        $this->ProductID = $ProductID;
    }

    function setProductVersion($ProductVersion)
    {
        $this->ProductVersion = $ProductVersion;
    }

    function setTelephone($Telephone)
    {
        $this->Telephone = $Telephone;
    }

    function setFax($Fax)
    {
        $this->Fax = $Fax;
    }

    function setEmail($Email)
    {
        $this->Email = $Email;
    }

    function setWebsite($Website)
    {
        $this->Website = $Website;
    }
}



class MasterFiles
{
    public $Customer = array();
    public $Product = array();
    public $TaxTable;

    function __construct()
    {
        $this->TaxTable = new TaxTable();
    }
    function getCustomer()
    {
        return $this->Customer;
    }

    function getProduct()
    {
        return $this->Product;
    }

    function getTaxTable()
    {
        return $this->TaxTable;
    }

    function setCustomer($Customer)
    {
        $this->Customer = $Customer;
    }

    function setProduct($Product)
    {
        $this->Product = $Product;
    }

    function setTaxTable($TaxTable)
    {
        $this->TaxTable = $TaxTable;
    }
}

class TaxTable
{

    public $TaxTableEntry = array();

    function __construct()
    {
    }
    function getTaxTableEntry()
    {
        return $this->TaxTableEntry;
    }

    function setTaxTableEntry($TaxTableEntry)
    {
        $this->TaxTableEntry = $TaxTableEntry;
    }
}
class SourceDocuments
{
    public $SalesInvoices;
    public $MovementOfGoods;
    public $WorkingDocuments;
    public $Payments;

    function __construct()
    {
        $this->SalesInvoices = new SalesInvoices();
        $this->MovementOfGoods = new MovementOfGoods();
        $this->WorkingDocuments = new WorkingDocuments();
        $this->Payments = new Payments();
    }
    function getSalesInvoices()
    {
        return $this->SalesInvoices;
    }

    function getMovementOfGoods()
    {
        return $this->MovementOfGoods;
    }

    function getWorkingDocuments()
    {
        return $this->WorkingDocuments;
    }

    function getPayments()
    {
        return $this->Payments;
    }

    function setSalesInvoices($SalesInvoices)
    {
        $this->SalesInvoices = $SalesInvoices;
    }

    function setMovementOfGoods($MovementOfGoods)
    {
        $this->MovementOfGoods = $MovementOfGoods;
    }

    function setWorkingDocuments($WorkingDocuments)
    {
        $this->WorkingDocuments = $WorkingDocuments;
    }

    function setPayments($Payments)
    {
        $this->Payments = $Payments;
    }
}

class SalesInvoices
{

    public $NumberOfEntries = "0";
    public $TotalDebit = "0.00";
    public $TotalCredit = "0.00";
    public $Invoice = array();

    function __construct()
    {
    }
    function getNumberOfEntries()
    {
        return $this->NumberOfEntries;
    }

    function getTotalDebit()
    {
        return $this->TotalDebit;
    }

    function getTotalCredit()
    {
        return $this->TotalCredit;
    }

    function getInvoice()
    {
        return $this->Invoice;
    }

    function setNumberOfEntries($NumberOfEntries)
    {
        $this->NumberOfEntries = $NumberOfEntries;
    }

    function setTotalDebit($TotalDebit)
    {
        $this->TotalDebit = $TotalDebit;
    }

    function setTotalCredit($TotalCredit)
    {
        $this->TotalCredit = $TotalCredit;
    }

    function setInvoice($Invoice)
    {
        $this->Invoice = $Invoice;
    }
}
class MovementOfGoods
{

    public $NumberOfMovementLines = "0";
    public $TotalQuantityIssued = "0";


    function __construct()
    {
    }
    function getNumberOfMovementLines()
    {
        return $this->NumberOfMovementLines;
    }

    function getTotalQuantityIssued()
    {
        return $this->TotalQuantityIssued;
    }

    function setNumberOfMovementLines($NumberOfMovementLines)
    {
        $this->NumberOfMovementLines = $NumberOfMovementLines;
    }

    function setTotalQuantityIssued($TotalQuantityIssued)
    {
        $this->TotalQuantityIssued = $TotalQuantityIssued;
    }
}
class WorkingDocuments
{

    public $NumberOfEntries = "0";
    public $TotalDebit = "0.00";
    public $TotalCredit = "0.00";
    public $WorkDocument = array();

    function __construct()
    {
        
    }
    function getNumberOfEntries()
    {
        return $this->NumberOfEntries;
    }

    function getTotalDebit()
    {
        return $this->TotalDebit;
    }

    function getTotalCredit()
    {
        return $this->TotalCredit;
    }

    function getWorkDocument()
    {
        return $this->WorkDocument;
    }

    function setNumberOfEntries($NumberOfEntries)
    {
        $this->NumberOfEntries = $NumberOfEntries;
    }

    function setTotalDebit($TotalDebit)
    {
        $this->TotalDebit = $TotalDebit;
    }

    function setTotalCredit($TotalCredit)
    {
        $this->TotalCredit = $TotalCredit;
    }

    function setWorkDocument($WorkDocument)
    {
        $this->WorkDocument = $WorkDocument;
    }
}

//
//class AllPayments
//{
//
//    public $NumberOfEntries = "0";
//    public $TotalDebit = "0.00";
//    public $TotalCredit = "0.00";
//    public $PaymentItem = array();
//
//    public function getNumberOfEntries()
//    {
//        return $this->NumberOfEntries;
//    }
//    public function setNumberOfEntries($NumberOfEntries)
//    {
//        $this->NumberOfEntries = $NumberOfEntries;
//    }
//    public function getTotalDebit()
//    {
//        return $this->TotalDebit;
//    }
//    public function setTotalDebit($TotalDebit)
//    {
//        $this->TotalDebit = $TotalDebit;
//    }
//    public function getTotalCredit()
//    {
//        return $this->TotalCredit;
//    }
//    public function setTotalCredit($TotalCredit)
//    {
//        $this->TotalCredit = $TotalCredit;
//    }
//    public function getPaymentItem()
//    {
//        return $this->PaymentItem;
//    }
//    public function setPaymentItem($PaymentItem)
//    {
//        $this->PaymentItem = $PaymentItem;
//    }
//}
class CompanyAddress
{

    public $AddressDetail = "Cruzeiro";
    public $City = "Luanda";
    public $Country = "AO";

    function getAddressDetail()
    {
        return $this->AddressDetail;
    }

    function getCity()
    {
        return $this->City;
    }

    function getCountry()
    {
        return $this->Country;
    }

    function setAddressDetail($AddressDetail)
    {
        $this->AddressDetail = $AddressDetail;
    }

    function setCity($City)
    {
        $this->City = $City;
    }

    function setCountry($Country)
    {
        $this->Country = $Country;
    }
}
