<?php

class WorkDocuments
{

    public $WorkDocument;
    
    function __construct($WorkDocument){
        $this->WorkDocument = $WorkDocument;
        
    }
    function getWorkDocument() {
        return $this->WorkDocument;
    }

    function setWorkDocument($WorkDocument) {
        $this->WorkDocument = $WorkDocument;
    }


    
}
