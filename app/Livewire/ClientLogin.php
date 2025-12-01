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

        if (Auth::attempt(['email' => $this->email, 'password' => $this->password], $this->remember)) {
            
            // Opcional: Se quiser impedir Admin de logar na loja
            /*
            if (Auth::user()->is_admin) {
                Auth::logout();
                $this->addError('email', 'Administradores devem logar pelo Painel.');
                return;
            }
            */

            session()->regenerate();
            return redirect(request()->header('Referer'));
        }

        $this->addError('email', 'E-mail ou senha incorretos.');
    }
    
    // ... resto do código igual ...
}