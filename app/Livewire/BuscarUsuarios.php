<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\User; // Certifique-se de que o modelo User está importado
use Livewire\WithPagination; // Adicionado para paginação

class BuscarUsuarios extends Component
{
    use WithPagination; // Usar o trait de paginação

    public $search = '';

    protected $listeners = ['refresh' => '$refresh'];

    public function render()
    {
        $query = User::query();

            $query->where('name', 'like', '%' . $this->search . '%')
            ->orWhere('email', 'like', '%' . $this->search . '%'); // Correção aqui
            $users = $query->orderBy('name', 'asc')->paginate(10);

        return view('livewire.buscar-usuarios', [
            'users' => $users,
        ]);
    }
}
