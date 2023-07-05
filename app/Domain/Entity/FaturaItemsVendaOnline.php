<?php

namespace App\Domain\Entity;

class FaturaItemsVendaOnline
{

    private $preco;
    private $quantidade;
    private $taxaIva;

    /**
     * @param $preco
     * @param $quantidade
     * @param $taxaIva
     */
    public function __construct($preco, $quantidade, $taxaIva)
    {
        $this->preco = $preco;
        $this->quantidade = $quantidade;
        $this->taxaIva = $taxaIva;
    }
    public function getSubTotal(){
        return $this->preco * $this->quantidade;
    }
    public function getSubTaxaIva(){
        if($this->taxaIva == 0) return 0;
        if(!$this->taxaIva) return 0;
        return (($this->preco * $this->quantidade) * $this->taxaIva) / 100;
    }

}
