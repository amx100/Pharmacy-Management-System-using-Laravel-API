<?php


namespace App\Http\Filters;

use App\Http\Filters\ApiFilter;

class DrugsFilter extends ApiFilter
{
    protected $safeParams = [
        'name' => ['eq'],
        'type' => ['eq'],
        'dose' => ['eq'],
        'selling_price' => ['eq', 'gt', 'lt'],
        'expiration_date' => ['eq'],
        'quantity' => ['eq', 'gt', 'lt'],
       
    ];

    protected $columnMap = [
        'selling_price' => 'SELLING_PRICE',
        'expiration_date' => 'EXPIRATION_DATE',
       
    ];

    protected $operatorMap = [
        'eq' => '=',
        'lt' => '<',
        'lte' => '<=',
        'gt' => '>',
        'gte' => '>=',
    ];
}
