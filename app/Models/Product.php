<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['name', 'description', 'price', 'stock_quantity', 'vendor_id'];

    // Many-to-many relationship with orders through order_items
    public function orders()
    {
        return $this->belongsToMany(Order::class, 'order_items')
            ->withPivot('quantity', 'price_at_purchase');
    }

    // A product belongs to a vendor
    public function vendor()
    {
        return $this->belongsTo(Vendor::class)->withTrashed();
    }
}

