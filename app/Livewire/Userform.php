<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Livewire\WithFileUploads;

class UserForm extends Component
{
    use WithFileUploads;

    public ?User $user = null; // Variável que armazena o objeto User (se for edição)

    // Variáveis ligadas aos campos do formulário (wire:model)
    public $name;
    public $email;
    public $password;

    protected function rules()
    {
        return [
            'name' => 'required|string|max:255',
            'email' => [
                'required', 
                'email', 
                'max:255', 
                // Único na tabela users, ignorando o ID atual se for edição
                Rule::unique('users', 'email')->ignore($this->user?->id)
            ],
            // Senha obrigatória apenas no cadastro (create)
            'password' => $this->user ? 'nullable|min:6' : 'required|min:6',
        ];
    }

    // --- AQUI ESTÁ A CORREÇÃO ---
    // Este método roda automaticamente ao carregar o componente.
    // Ele pega o usuário enviado pela rota/controller e preenche os campos.
    public function mount($user = null)
    {
        if ($user) {
            // MODO EDIÇÃO: Preenche os campos com os dados do banco
            $this->user = $user;
            $this->name = $user->name;
            $this->email = $user->email;
        }
    }

    // ...
public function save()
{
    
    $this->validate(); // Se falhar aqui, ele para e mostra erros na view

    $data = [
        'name' => $this->name,
        'email' => $this->email,
    ];

    if (!empty($this->password)) {
        $data['password'] = Hash::make($this->password);
    }

    if ($this->user) {
        $this->user->update($data);
        session()->flash('success', 'Usuário atualizado!');
    } else {
        User::create($data); // <--- O erro pode estar aqui se o banco não permitir nulos
        session()->flash('success', 'Usuário criado!');
    }

    return redirect()->route('usuarios');
}

    public function render()
{
    // O nome aqui deve ser igual ao nome do arquivo na pasta views/livewire
    return view('livewire.userform'); 
}
}