<?php
// app/Http/Filters/V1/PurchasesFilter.php

namespace App\Http\Filters;

use App\Http\Filters\ApiFilter;

class PurchasesFilter extends ApiFilter
{
    protected $safeParams = [
        'customer_id' => ['eq'],
        'drug_id' => ['eq'],
        'purchase_date' => ['eq','gt','lt'],
        'quantity_purchased' => ['eq', 'gt', 'lt'],
        'total_bill' => ['eq', 'gt', 'lt'],
        'IS_REFUNDED' => ['eq']
 
    ];

    protected $columnMap = [
        'customer_id' => 'CUSTOMER_ID',
        'drug_id' => 'DRUG_ID',
        'purchase_date' => 'PURCHASE_DATE',
        'IS_REFUNDED' => 'IS_REFUNDED'
      
    ];

    protected $operatorMap = [
        'eq' => '=',
        'lt' => '<',
        'lte' => '<=',
        'gt' => '>',
        'gte' => '>=',
    ];
}
