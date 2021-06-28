<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\OrderItem;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'reference_no',
        'tax',
        'service_charge',
        'total',
        'status'
    ];
    

        
    public function products() {
        return $this->hasMany(OrderItem::class,'order_id','id');
     }

     public function transaction() {
        return $this->hasOne(Transaction::class,'order_id','id');
    }



}
