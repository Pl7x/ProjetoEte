<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    protected $guarded = [];

    // Relação: Um item de pedido pertence a um Produto original
    // Isso permite que a gente pegue o nome e a foto do produto depois.
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}