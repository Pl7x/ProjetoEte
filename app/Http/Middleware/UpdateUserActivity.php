<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class UpdateUserActivity
{
    public function handle(Request $request, Closure $next): Response
    {
        // Verifica se o usuário está logado
        if (Auth::check()) {
            /** @var \App\Models\User $user */
            $user = Auth::user();
            // Atualiza a data da última atividade
            $user->updateLastActivity();
        }

        return $next($request);
    }
}