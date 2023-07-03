<?php

namespace App\Domain\Entity;

class FaturaItemsVendaOnline
{

    private $preco;
    private $quantidade;
    private $taxaIva;

    public function getSubTotal(){
        return $this->preco * $this->quantidade;
    }
    public function getSubTaxaIva(){
        return (($this->preco * $this->quantidade) * $this->taxaIva) / 100;
    }

}
