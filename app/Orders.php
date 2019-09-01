<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Orders extends Model
{
    protected $fillable = [
        'order_id',
        'order_datetime',
        'total_order_value', 
        'average_unit_price',
        'distinct_unit_count', 
        'total_units_count',
        'customer_state', 
        'product_list'
    ];

    protected $hidden = [
        'id', 'product_list', 'created_at', 'updated_at'
    ];
}
