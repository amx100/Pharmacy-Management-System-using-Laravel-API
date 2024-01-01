<?php
namespace App\Http\Filters;

use App\Http\Filters\ApiFilter;

class CustomersFilter extends ApiFilter
{
    protected $safeParams = [
        'first_name' => ['eq'],
        'last_name' => ['eq'],
        'dob' => ['eq'],
       
    ];

    protected $columnMap = [
        'first_name' => 'FIRST_NAME',
        'last_name' => 'LAST_NAME',
      
    ];

    protected $operatorMap = [
        'eq' => '=',
     
    ];
}