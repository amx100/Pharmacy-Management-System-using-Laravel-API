<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Drug extends Model
{
    use HasFactory;
    protected $table = 'drugs';
    protected $primaryKey = 'DRUG_ID';
    public $timestamps = false;

    protected $fillable = [
        'NAME',
        'TYPE',
        'DOSE',
        'SELLING_PRICE',
        'EXPIRATION_DATE',
        'QUANTITY',
    ];



   public function customer()
   {
       return $this->belongsTo(Customer::class, 'CUSTOMER_ID', 'CUSTOMER_ID');
   }

   public function purchaseHistories()
    {
        return $this->hasMany(Purchase::class, 'DRUG_ID', 'DRUG_ID');
    }

    public function scopePurchased($query)
    {
        return $query->whereHas('purchaseHistories');
    }

}
