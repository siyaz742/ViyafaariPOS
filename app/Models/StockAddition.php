<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StockAddition extends Model
{
    protected $fillable = ['batch_id', 'product_id', 'initial_amount', 'quantity_added', 'final_amount','user_id'];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

}

