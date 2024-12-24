<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Helper\ResponseHelper;
use Illuminate\Http\JsonResponse;

class Customer extends Model
{
    protected $fillable = ['name','district', 'addressDetails','mobile','user_id'];

    public function user(): BelongsTo{
        return $this->belongsTo(User::class,"user_id",'id');   //'id' added 
    }

}

