<?php

namespace App\Livewire;

use App\Models\User;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;

class BuscarUsuarios extends Component
{
    use WithPagination;
    #[Url(as:'search')]
    public $search = '';

    protected $listeners = ['refresh' => '$refresh'];
    
    public function render()
    {
        $query = User::query()
            ->where('name', 'like', '%' . $this->search . '%')
            
            ->orderBy('name', 'asc');

        $users = $query->paginate(10);
            
        return view('livewire.buscar-usuarios', [
            'users' => $users,
        ]);
    }

}