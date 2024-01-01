<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CustomerResource extends JsonResource
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
            'CUSTOMER_ID' => $this->CUSTOMER_ID,
            'FIRST_NAME' => $this->FIRST_NAME,
            'LAST_NAME' => $this->LAST_NAME,
            'DOB' => $this->DOB,
            'purchaseHistories' => PurchaseResource::collection($this->whenLoaded('purchaseHistories'))
        ];
    }
}
