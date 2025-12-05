<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    // Permite que a gente salve todos os dados de uma vez (Mass Assignment)
    protected $guarded = [];

    // ISSO É IMPORTANTE: Avisa ao Laravel que o campo 'shipping_address' 
    // é um array/JSON, então ele converte automaticamente para nós.
    protected $casts = [
        'shipping_address' => 'array',
    ];

    // Relação: Um pedido tem muitos itens
    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }


    public function getStatusFormatadoAttribute()
{
    return match($this->status) {
        'paid' => 'Pago',
        'pending' => 'Pendente',
        'failed' => 'Falhou',
        default => $this->status,
    };
}


    // Relação: Um pedido pertence a um cliente (opcional)
    public function client()
    {
        return $this->belongsTo(Client::class);
    }
}