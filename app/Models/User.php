<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Http\Controllers\Admin\Usercontroller;
use App\Http\Middleware\AdminMiddleware;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name', 'email', 'password', 'last_activity', 'is_admin', // <--- Importante
    ];

    protected $hidden = ['password', 'remember_token'];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'last_activity' => 'datetime',
            'is_admin' => 'boolean',
        ];
    }

    public function isOnline()
    {
        return $this->last_activity && $this->last_activity->diffInMinutes(now()) < 5;
    }
}