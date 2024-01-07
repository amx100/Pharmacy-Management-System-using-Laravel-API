<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PurchaseResource extends JsonResource
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
            'PURCHASE_ID' => $this->PURCHASE_ID,
            'CUSTOMER_ID' => $this->CUSTOMER_ID,
            'DRUG_ID' => $this->DRUG_ID,
            'PURCHASE_DATE' => $this->PURCHASE_DATE,
            'QUANTITY_PURCHASED' => $this->QUANTITY_PURCHASED,
            'TOTAL_BILL' => $this->TOTAL_BILL,
            'IS_REFUNDED' => $this->IS_REFUNDED,
            'customer_name' => $this->customer->FIRST_NAME . ' ' . $this->customer->LAST_NAME,
        ];
    }
}