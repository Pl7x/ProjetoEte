<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\Attributes\Layout;
use Illuminate\Support\Facades\Password;
use App\Models\Client; // <--- IMPORTANTE: Importar o Model do Cliente

#[Layout('layouts.app')]
class ClientForgotPassword extends Component
{
    public $email;
    public $status;

    public function sendResetLink()
    {
        $this->validate(['email' => 'required|email']);

        // 1. VERIFICAÇÃO EXPLICITA: O cliente existe?
        $clienteExiste = Client::where('email', $this->email)->exists();

        if (!$clienteExiste) {
            // Se não existe, adiciona o erro e para a execução aqui
            $this->addError('email', 'Não há cliente cadastrado com esse e-mail.');
            return;
        }

        // 2. Se chegou aqui, o cliente existe. Pode enviar.
        $response = Password::broker('clients')->sendResetLink(['email' => $this->email]);

        if ($response == Password::RESET_LINK_SENT) {
            $this->status = __($response);
            session()->flash('status', 'Link enviado! Verifique seu e-mail.');
            $this->email = '';
        } else {
            $this->addError('email', __($response));
        }
    }

    public function render()
    {
        return view('livewire.client-forgot-password');
    }
}