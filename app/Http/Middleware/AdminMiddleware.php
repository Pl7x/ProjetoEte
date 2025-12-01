<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        // 1. Verifica se o usuário está logado
        // 2. Verifica se o campo 'is_admin' é verdadeiro (1)
        if (Auth::check() && Auth::user()->is_admin) {
            return $next($request); // Deixa passar para o painel
        }

        // Se não for admin, faz logout forçado e manda para a home com erro
        // (Opcional: apenas redirecionar sem deslogar, depende de como prefere)
        return redirect('/')->with('error', 'Acesso negado. Área restrita.');
    }
}