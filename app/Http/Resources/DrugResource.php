<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class DrugResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  Request  $request
     * @return array<string, mixed>
     */
    public function toArray($request): array
    {
        return [
            'DRUG_ID' => $this->DRUG_ID,
            'NAME' => $this->NAME,
            'TYPE' => $this->TYPE,
            'DOSE' => $this->DOSE,
            'SELLING_PRICE' => $this->SELLING_PRICE,
            'EXPIRATION_DATE' => $this->EXPIRATION_DATE,
            'QUANTITY' => $this->QUANTITY,
            'purchaseHistories' => PurchaseResource::collection($this->whenLoaded('purchaseHistories'))
        ];
    }
}