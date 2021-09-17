<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class SaleResource extends JsonResource
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
            'codigo' => $this->id,
            'seller' => $this->seller->name,
            'preco'   => $this->price,
            'comissao'   => $this->getComission($this->price),
            'data_criacao'   => $this->created_at,
        ];
    }
}