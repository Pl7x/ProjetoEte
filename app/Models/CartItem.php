<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CartItem extends Model
{
    use HasFactory;

    protected $fillable = ['client_id', 'product_id', 'quantity'];

    // Relacionamento com o Produto
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    // Relacionamento com o Cliente
    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    // Helper para calcular subtotal
    public function getSubtotalAttribute()
    {
        return $this->product->price * $this->quantity;
    }
}
