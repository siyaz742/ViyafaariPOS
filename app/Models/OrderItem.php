<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    use HasFactory;

    protected $fillable = ['order_id', 'product_id','item_sale_price',  'price',  'discount', 'quantity', 'item_total'];

    public static $rules = [
        'discount' => 'nullable|numeric|min:0|max:100',
    ];

    // Each order item belongs to one order
    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    // Each order item is associated with one product
    public function product()
    {
        return $this->belongsTo(Product::class)->withTrashed();
    }
}

