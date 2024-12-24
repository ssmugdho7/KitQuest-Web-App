<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Invoice extends Model
{
    protected $fillable = ['total',
      'vat',
       'payable', 
       'delivery_status',
        'payment_status',
        'cus_details',
        'user_id'];

    function user():BelongsTo{
        return $this->belongsTo(User::class);
    }
    public function customer()
    {
        return $this->belongsTo(Customer::class, 'user_id', 'user_id');
    }

}
