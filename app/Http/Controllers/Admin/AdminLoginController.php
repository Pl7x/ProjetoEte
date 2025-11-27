<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminLoginController extends Controller
{
    // Mostra o formulário de login
    public function showLoginForm()
    {
        if (Auth::guard('admin')->check()) {
            return redirect()->route('painel.dashboard');
        }
        return view('admin.auth.login');
    }

    // Processa o login
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        // Tenta logar usando especificamente o GUARD 'admin'
        if (Auth::guard('admin')->attempt($credentials, $request->filled('remember'))) {
            $request->session()->regenerate();

            // Atualiza a última atividade ao logar
            /** @var \App\Models\Admin $admin */
            $admin = Auth::guard('admin')->user();
            $admin->updateLastActivity();

            return redirect()->intended(route('painel.dashboard'));
        }

        return back()->withErrors([
            'email' => 'As credenciais fornecidas estão incorretas.',
        ])->onlyInput('email');
    }

    // Processa o logout
    public function logout(Request $request)
    {
        Auth::guard('admin')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('admin.login');
    }
}