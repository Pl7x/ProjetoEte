<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class ClientLogin extends Component
{
    public $email;
    public $password;
    public $remember = false;

    protected $rules = [
        'email' => 'required|email',
        'password' => 'required',
    ];

    public function login()
    {
        $this->validate();

        // AQUI MUDAMOS: Usamos o guard 'client'
        if (Auth::guard('client')->attempt(['email' => $this->email, 'password' => $this->password], $this->remember)) {
            session()->regenerate();
            return redirect(request()->header('Referer'));
        }

        $this->addError('email', 'E-mail ou senha incorretos.');
    }

    public function logout()
    {
        Auth::guard('client')->logout(); // Logout específico do cliente
        session()->invalidate();
        session()->regenerateToken();
        return redirect('/');
    }

    public function render()
    {
        return view('livewire.client-login');
    }
}