<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProductReview extends Model
{
    protected $fillable = ['description','rating','customer_id','product_id'];
    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class,'customer_id');
    }
}
