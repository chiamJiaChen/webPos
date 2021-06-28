<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Product;
use App\Models\Transaction;

class OrderItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id',
        'price',
        'quantity',
        'status',
    ];

    
    public function product() {
        return $this->hasOne(Product::class,'id','product_id');
    }
     

}
