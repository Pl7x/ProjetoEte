<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $guarded = [];

    protected $casts = [
        'shipping_address' => 'array',
        'shipped_at' => 'datetime', // <--- ADICIONAR ESTA LINHA
    ];

    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function getStatusFormatadoAttribute()
    {
        return match($this->status) {
            'paid' => 'Pago',
            'shipped' => 'Enviado', // Adicionado
            'pending' => 'Pendente',
            'failed' => 'Falhou',
            default => $this->status,
        };
    }

    public function client()
    {
        return $this->belongsTo(Client::class);
    }
}