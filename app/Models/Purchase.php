<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Purchase extends Model
{
    use HasFactory;
    protected $table = 'purchase_history';
    protected $primaryKey = 'PURCHASE_ID';
    public $timestamps = false;

    protected $touches = ['drug'];

    protected $fillable = [
        'CUSTOMER_ID',
        'DRUG_ID',
        'PURCHASE_DATE',
        'QUANTITY_PURCHASED',
        'IS_REFUNDED'
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($purchase) {
            $drug = $purchase->drug;
            $purchase->TOTAL_BILL = $drug->SELLING_PRICE * $purchase->QUANTITY_PURCHASED;
        });
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class, 'CUSTOMER_ID', 'CUSTOMER_ID');
    }

    public function drug()
    {
        return $this->belongsTo(Drug::class, 'DRUG_ID', 'DRUG_ID');
    }
}
