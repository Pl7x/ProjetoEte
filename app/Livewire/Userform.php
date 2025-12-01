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

    public ?User $user = null;
    public $name;
    public $email;
    public $password;

    protected function rules()
    {
        return [
            // Se for edição, o nome é required mas nós não o atualizaremos,
            // então a validação apenas garante que o campo não venha vazio do front.
            'name' => 'required|string|max:255',
            'email' => [
                'required',
                'email',
                'max:255',
                Rule::unique('users', 'email')->ignore($this->user?->id)
            ],
            'password' => $this->user ? 'nullable|min:6' : 'required|min:6',
        ];
    }

    public function mount($user = null)
    {
        if ($user) {
            $this->user = $user;
            $this->name = $user->name;
            $this->email = $user->email;
        }
    }

    public function save()
    {
        $this->validate();

        // Dados comuns para atualização
        $data = [
            'email' => $this->email,
        ];

        // Se senha foi preenchida, adiciona ao array de dados
        if (!empty($this->password)) {
            $data['password'] = Hash::make($this->password);
        }

        if ($this->user) {
            // MODO EDIÇÃO: Não incluímos 'name' no $data,
            // garantindo que o nome original permaneça inalterado no banco.
            $this->user->update($data);
            session()->flash('success', 'Usuário atualizado!');
        } else {
            // MODO CRIAÇÃO: Adicionamos o nome
            $data['name'] = $this->name;
            User::create($data);
            session()->flash('success', 'Usuário criado!');
        }

        return redirect()->route('usuarios');
    }

    public function render()
    {
        return view('livewire.userform');
    }
}
