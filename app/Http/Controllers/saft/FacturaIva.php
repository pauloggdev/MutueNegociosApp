<?php


use App\Http\Controllers\saft\AuditFile;

class FacturaIva
{
    public $AuditFile;

    function __construct()
     {
        $this->AuditFile = new AuditFile();
    }
    function getAuditFile() {
        return $this->AuditFile;
    }

    function setAuditFile($AuditFile) {
        $this->AuditFile = $AuditFile;
    }


}
