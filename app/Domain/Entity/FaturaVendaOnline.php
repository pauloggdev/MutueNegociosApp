<?php

namespace App\Domain\Entity;

class FaturaVendaOnline
{

    private  $items = [];
    private $nomeCliente;
    private $nifCliente;
    private $emailCliente;
    private $enderecoCliente;

    private CouponDesconto $couponDesconto;

    public function __construct(array $items, $couponDesconto)
    {
        $this->items = $items;
        $this->couponDesconto = $couponDesconto;
    }
    public function addItem(FaturaItemsVendaOnline $item){
        array_push($this->items, $item);
    }

    public function getTotal(){

        $total = 0;
        foreach ($this->items as $item){
            $total+= $item->getSubTotal();
        }
        return $total;
    }
    public function getTaxaIva(){
        $total = 0;
        foreach ($this->items as $item){
            $total+= $item->getSubTaxaIva();
        }
        return $total;
    }

    public function getDesconto(){
        if(!$this->couponDesconto->isValid()) return 0;
        return ($this->getTotal() * $this->couponDesconto->getPercentagem())/100;
    }
    public function getTotalPagar(){
        return $this->getTotal() + $this->getTaxaIva() - $this->getDesconto();
    }
}
