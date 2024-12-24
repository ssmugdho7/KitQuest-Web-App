<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Product extends Model
{

   protected $fillable = [ 'category_id', 'name', 'price', 'unit', 'img_url', 'discount', 'discount_price', 'stock','stock','star','remark'];

    
   public function category(): BelongsTo
   {
       return $this->belongsTo(Category::class);
   }


   public function details()
{
    return $this->hasOne(ProductDetails::class);
}
}
