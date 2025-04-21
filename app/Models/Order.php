<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'customer_id', 'employee_id', 'invoice_date',
        'invoice_time', 'total', 'payment_method'
    ];

    // An order belongs to a customer
    public function customer()
    {
        return $this->belongsTo(Customer::class)->withTrashed();
    }

    // An order belongs to an employee (user)
    public function employee()
    {
        return $this->belongsTo(User::class)->withTrashed();
    }


    // An order has many order items (pivot between order and products)
    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }
}

