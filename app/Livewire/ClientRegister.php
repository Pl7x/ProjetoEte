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

    // Adicione a propriedade pública
public $phone; 

public function register()
{
    // 1. LIMPEZA (CPF, CEP e agora TELEFONE)
    $this->cpf = preg_replace('/[^0-9]/', '', $this->cpf);
    $this->cep = preg_replace('/[^0-9]/', '', $this->cep);
    $this->phone = preg_replace('/[^0-9]/', '', $this->phone); // <--- Limpa o telefone

    // 2. VALIDAÇÃO
    $this->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|email|unique:clients,email',
        'cpf'   => 'required|string|digits:11',
        'phone' => 'required|string|min:10|max:11', // <--- Valida celular ou fixo
        'password' => 'required|min:6|confirmed',
        'cep' => 'required|string|digits:8',
        'endereco' => 'required|string',
        'numero' => 'required|string',
        'bairro' => 'required|string',
        'cidade' => 'required|string',
        'estado' => 'required|string|max:2',
    ]);

    // 3. CRIAÇÃO
    $client = Client::create([
        'name' => $this->name,
        'email' => $this->email,
        'phone' => $this->phone, // <--- Salva o telefone
        'cpf' => $this->cpf,
        'password' => Hash::make($this->password),
        'cep' => $this->cep,
        'endereco' => $this->endereco,
        'numero' => $this->numero,
        'complemento' => $this->complemento,
        'bairro' => $this->bairro,
        'cidade' => $this->cidade,
        'estado' => $this->estado,
    ]);

    Auth::guard('client')->login($client);
    return redirect(request()->header('Referer'));
}

    public function render()
    {
        return view('livewire.client-register');
    }
}