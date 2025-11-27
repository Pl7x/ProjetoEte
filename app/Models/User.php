<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory; 
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
class User extends Authenticatable
{


    protected $fillable = [
        'name',
        'email',
        'password',
        'last_activity', // Adicione last_activity ao fillable
    ];

    // ...

    protected $casts = [
        // ...
        'last_activity' => 'datetime', // Adicione o cast para datetime
    ];

    // ...

    public function isOnline()
    {
        return $this->last_activity && $this->last_activity->diffInMinutes(now()) < 5; // Ajuste o tempo conforme necessário
    }

    public function updateLastActivity()
    {
        $this->update(['last_activity' => now()]);
    }
}