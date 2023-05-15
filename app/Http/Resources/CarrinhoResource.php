<?php

namespace App\Http\Resources;
use Illuminate\Http\Resources\Json\JsonResource;

class CarrinhoResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            
            'id'=>$this->id,
            'quantidade'=> $this->quantidade,
            'produto_id'=> $this->produto_id,
            'cliente_id' => $this->cliente_id,
            'produto' => new ProdutoResource($this->produto),
            'subtotal' => $this->produto->preco_venda * $this->quantidade
        ];
    }
}
