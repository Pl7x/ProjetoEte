<?php

namespace App\Livewire;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Login extends Component
{

     public $email;
     public $password;

    public function login()
    {

        $this->validate([
            'email' => 'required|email',
            'password' => 'required|min:6',
        ]);

        $authenticated = Auth::attempt([
            'email' => $this->email,
            'password' => $this->password,
        ]);

        if ($authenticated) {
            return redirect()->route('painel');
        } else {
            session()->flash('error', 'Email ou senha inválido.');
        }

    }
    public function render()
    {
        return view('livewire.admin.login');
    }
}
