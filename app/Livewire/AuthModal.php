<?php

namespace App\Livewire;

use Livewire\Component;

class AuthModal extends Component
{
    // false = Mostra Login, true = Mostra Registro
    public $showRegister = false; 

    // Ouve o evento 'toggleAuthMode' para trocar a tela
    protected $listeners = ['toggleAuthMode' => 'toggleMode'];

    public function toggleMode()
    {
        $this->showRegister = !$this->showRegister;
    }

    public function render()
    {
        return view('livewire.auth-modal');
    }
}