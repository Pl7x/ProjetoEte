<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ClientRegister extends Component
{
    // Dados Pessoais
    public $name;
    public $email;
    public $cpf;
    public $password;
    public $password_confirmation;

    // Endereço
    public $cep;
    public $endereco;
    public $numero;
    public $complemento;
    public $bairro;
    public $cidade;
    public $estado;

    protected $rules = [
        'name' => 'required|string|max:255',
        'email' => 'required|email|unique:users,email',
        'cpf'   => 'required|string|max:14', // Idealmente usar validação de CPF real depois
        'password' => 'required|min:6|confirmed',
        
        // Regras de Endereço
        'cep' => 'required|string|max:9',
        'endereco' => 'required|string',
        'numero' => 'required|string',
        'bairro' => 'required|string',
        'cidade' => 'required|string',
        'estado' => 'required|string|max:2',
    ];

    public function register()
    {
        $this->validate();

        $user = User::create([
            'name' => $this->name,
            'email' => $this->email,
            'cpf' => $this->cpf,
            'password' => Hash::make($this->password),
            
            // Salvar Endereço
            'cep' => $this->cep,
            'endereco' => $this->endereco,
            'numero' => $this->numero,
            'complemento' => $this->complemento,
            'bairro' => $this->bairro,
            'cidade' => $this->cidade,
            'estado' => $this->estado,
        ]);

        Auth::login($user);

        return redirect(request()->header('Referer'));
    }

    public function render()
    {
        return view('livewire.client-register');
    }
}