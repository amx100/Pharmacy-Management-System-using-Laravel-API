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

   // app/Models/Drug.php

   public function customer()
   {
       return $this->belongsTo(Customer::class, 'CUSTOMER_ID', 'CUSTOMER_ID');
   }

}
