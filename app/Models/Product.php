<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = ['name', 'sku', 'description', 'price', 'inventory', 'image'];

    public function orderItems() {
        return $this->hasMany(OrderItem::class);
    }
}