<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Helper\ResponseHelper;
use Illuminate\Http\JsonResponse;

class ProductDetails extends Model
{



    protected $fillable=[
        'product_id',
        "img1",
        'color',
        'size',
      "des"
    ];

     function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }
}
