<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Client;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ClientRegister extends Component
{
    public $name;
    public $email;
    public $cpf;
    public $password;
    public $password_confirmation;

    public $cep;
    public $endereco;
    public $numero;
    public $complemento;
    public $bairro;
    public $cidade;
    public $estado;

    // Removemos as regras daqui para usá-las diretamente no método register,
    // pois precisamos limpar os dados (remover máscaras) ANTES de validar.

    public function register()
    {
        // 1. LIMPEZA: Remove tudo que não for número do CPF e CEP
        $this->cpf = preg_replace('/[^0-9]/', '', $this->cpf);
        $this->cep = preg_replace('/[^0-9]/', '', $this->cep);

        // 2. VALIDAÇÃO: Agora validamos os dados "limpos"
        $this->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:clients,email',
            'cpf'   => 'required|string|digits:11', // Exige exatamente 11 números
            'password' => 'required|min:6|confirmed',
            'cep' => 'required|string|digits:8',    // Exige exatamente 8 números
            'endereco' => 'required|string',
            'numero' => 'required|string',
            'bairro' => 'required|string',
            'cidade' => 'required|string',
            'estado' => 'required|string|max:2',
        ]);

        // 3. CRIAÇÃO DO CLIENTE
        $client = Client::create([
            'name' => $this->name,
            'email' => $this->email,
            'cpf' => $this->cpf, // Salva apenas números (ideal para BD)
            'password' => Hash::make($this->password),
            'cep' => $this->cep, // Salva apenas números
            'endereco' => $this->endereco,
            'numero' => $this->numero,
            'complemento' => $this->complemento,
            'bairro' => $this->bairro,
            'cidade' => $this->cidade,
            'estado' => $this->estado,
        ]);

        // 4. LOGIN E REDIRECIONAMENTO
        Auth::guard('client')->login($client);

        return redirect(request()->header('Referer'));
    }

    public function render()
    {
        return view('livewire.client-register');
    }
}