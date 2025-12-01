<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class AuthModal extends Component
{
    public $showRegister = false; 

    // Mude os listeners para usar o formato correto de evento
    // Em vez de $listeners = ['toggleAuthMode' => 'toggleMode'];
    // Use o atributo #[On('toggleAuthMode')] no método toggleMode, se estiver usando PHP 8+ e Livewire 3
    // OU registre no método getListeners()
    
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