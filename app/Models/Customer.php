<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;
    protected $table = 'customers';
    protected $primaryKey = 'CUSTOMER_ID';
    public $timestamps = false;

    protected $fillable = [
        'FIRST_NAME',
        'LAST_NAME',
        'DOB',
    ];
}
