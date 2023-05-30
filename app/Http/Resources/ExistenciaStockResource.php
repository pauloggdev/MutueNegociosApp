<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ExistenciaStockResource extends JsonResource
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
            'quantidade' => $this->quantidade,
            'quantidade_nova'=> 0,
            'armazem' => new ArmazemResource($this->armazem),
            'produto'=> new ProdutoResource($this->produto)
        ];
    }
}
