<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable; // Importante!
use Illuminate\Notifications\Notifiable;

class Client extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $guard = 'client'; // Define que usa o guard 'client'

    protected $fillable = [
    'name', 'email', 'phone', 'cpf', 'password', // <--- Adicionado 'phone'
    'cep', 'endereco', 'numero', 'complemento', 'bairro', 'cidade', 'estado'
];

    protected $hidden = [
        'password', 'remember_token',
    ];

    protected $casts = [
        'password' => 'hashed',
    ];
}