<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class UpdateAdminActivity
{
    public function handle(Request $request, Closure $next): Response
    {
        // Verifica se o usuário está logado como admin
        if (Auth::guard('admin')->check()) {
            /** @var \App\Models\Admin $user */
            $user = Auth::guard('admin')->user();
            // Atualiza a data da última atividade
            $user->updateLastActivity();
        }

        return $next($request);
    }
}