<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    protected $guarded = [];

    // Relação: Um item pertence a um Produto
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    // --- ADICIONE ESTA FUNÇÃO QUE FALTAVA ---
    // Relação: Um item pertence a um Pedido
    public function order()
    {
        return $this->belongsTo(Order::class);
    }
}