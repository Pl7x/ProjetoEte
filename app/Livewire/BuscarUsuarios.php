<?php

namespace App\Livewire;

use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;

class BuscarUsuarios extends Component
{
    use WithPagination;

    public $searchTerm = '';

    public function render()
    {
        $users = User::where('name', 'like', '%' . $this->searchTerm . '%')
            ->orWhere('email', 'like', '%' . $this->searchTerm . '%')
            ->paginate(10);

        return view('livewire.buscar-usuarios', [
            'users' => $users,
        ]);
    }
}