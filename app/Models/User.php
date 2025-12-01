<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
protected $fillable = [
        'name',
        'email',
        'password',
        'last_activity',
        'is_admin',
        // NOVOS CAMPOS:
        'cpf',
        'cep',
        'endereco',
        'numero',
        'complemento',
        'bairro',
        'cidade',
        'estado',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'last_activity' => 'datetime', // Adicionado o cast para datetime
        ];
    }

    // Método para verificar se o usuário está online
    public function isOnline()
    {
        return $this->last_activity && $this->last_activity->diffInMinutes(now()) < 5; // Ajuste o tempo conforme necessário
    }

    // Método para atualizar a última atividade do usuário
    public function updateLastActivity()
    {
        $this->update(['last_activity' => now()]);
    }
}