<?php

namespace App\Domain\Entity;

class FaturaVendaOnline
{
    private  $items = [];
    private $nomeCliente;
    private $nifCliente;
    private $emailCliente;
    private $enderecoCliente;
    private $telefoneCliente;
    private $contaCorrenteCliente;
    private $clienteId;
    private $numeracaoDocumento;
    private $numSequenciaDocumeto;

    private CouponDesconto $couponDesconto;

    private $observacao;

    public function __construct($nomeCliente, $nifCliente, $emailCliente, $enderecoCliente,$telefoneCliente, $contaCorrenteCliente, $clienteId, $numeracaoDocumento, $numSequenciaDocumeto, $observacao, CouponDesconto $couponDesconto)
    {
        $this->nomeCliente = $nomeCliente;
        $this->nifCliente = $nifCliente;
        $this->emailCliente = $emailCliente;
        $this->enderecoCliente = $enderecoCliente;
        $this->telefoneCliente = $telefoneCliente;
        $this->contaCorrenteCliente = $contaCorrenteCliente;
        $this->numeracaoDocumento = $numeracaoDocumento;
        $this->numSequenciaDocumeto = $numSequenciaDocumeto;
        $this->clienteId = $clienteId;
        $this->couponDesconto = $couponDesconto;
        $this->observacao = $observacao;
    }
    public function addItem($item){
        $this->items[] = $item;
    }
    public function getNomeCliente(){
        return $this->nomeCliente;
    }
    public function getNifCliente(){
        return $this->nifCliente;
    }
    public function getEmailCliente(){
        return $this->emailCliente;
    }
    public function getTelefoneCliente(){
        return $this->telefoneCliente;
    }
    public function getContaCorrenteCliente(){
        return $this->contaCorrenteCliente;
    }
    public function getEnderecoCliente(){
        return $this->enderecoCliente;
    }
    public function getClienteId(){
        return $this->clienteId;
    }
    public function getNumeracaoDocumento(){
        return $this->numeracaoDocumento;
    }
    public function getNumSequenciaDocumento(){
        return $this->numSequenciaDocumeto;
    }
    public function getObservacao(){
        return $this->observacao;
    }
    public function getItems(){
        return $this->items;
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
    public function getTotalIncidencia(){
        return $this->getTotal() - $this->getDesconto();
    }
    public function getRetencao(){
        return 0;
    }
    public function getTroco(){
        return 0;
    }
    public function getQuantItems(){
        return count($this->items);
    }

    public function getDesconto(){
        if(!$this->couponDesconto->isValid()) return 0;
        return ($this->getTotal() * $this->couponDesconto->getPercentagem())/100;
    }
    public function getTotalPagar(){
        return $this->getTotal() + $this->getTaxaIva() - $this->getDesconto();
    }
}
