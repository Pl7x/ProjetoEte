<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use App\Models\User; // Importante: Importe o Model do Admin

class UpdateUserActivity
{
    public function handle(Request $request, Closure $next)
    {
        if (Auth::check()) {
            $user = Auth::user();

            // CORREÇÃO: Verifica se o usuário é uma instância de 'User' (Admin)
            // Assim, ele ignora se for um 'Client'
            if ($user instanceof User) {
                
                // Verifica se o método existe por segurança extra
                if (method_exists($user, 'updateLastActivity')) {
                    $user->updateLastActivity();
                }
            }
        }

        return $next($request);
    }
}