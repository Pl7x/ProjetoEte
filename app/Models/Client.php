<?php

namespace App\Models;

// ATENÇÃO: Não use 'Illuminate\Database\Eloquent\Model'
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Client extends Authenticatable
{
    use Notifiable;

    // Campos que podem ser preenchidos
    protected $fillable = [
        'name',
        'email',
        'phone',
        'cpf',
        'password',
        'cep',
        'endereco',
        'numero',
        'complemento',
        'bairro',
        'cidade',
        'estado',
    ];

    // Campos escondidos (segurança)
    protected $hidden = [
        'password',
        'remember_token',
    ];

    // Garante que a senha seja tratada corretamente
    protected function casts(): array
    {
        return [
            'password' => 'hashed',
        ];
    }

    // --- ADICIONE ESTA FUNÇÃO QUE FALTAVA ---
    // Relação: Um Cliente tem muitos Pedidos
    public function orders()
    {
        return $this->hasMany(Order::class);
    }
}