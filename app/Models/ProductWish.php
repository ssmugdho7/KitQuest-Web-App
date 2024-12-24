<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProductWish extends Model
{
    protected $fillable = ['product_id','customer_id'];
    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }
    
    public function customer(): BelongsTo           //added
    {
        return $this->belongsTo(Customer::class, 'customer_id', 'id');
    }

}


//added 

