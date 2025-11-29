<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class BuscarUsuarios extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap'; // Importante para o visual

    public $search = '';
    public $userIdToDelete;
    public $userNameToDelete;

    public function updatingSearch() { $this->resetPage(); }

    public function confirmDelete($userId)
    {
        $this->userIdToDelete = $userId;
        $user = User::find($userId);
        if ($user) {
            $this->userNameToDelete = $user->name;
            $this->dispatch('show-delete-modal');
        }
    }

    public function deleteUser()
    {
        if ($this->userIdToDelete == Auth::id()) {
            session()->flash('error', 'Você não pode excluir sua própria conta!');
        } else {
            User::destroy($this->userIdToDelete);
            session()->flash('success', 'Usuário excluído com sucesso!');
        }
        $this->dispatch('hide-delete-modal');
    }

    public function render()
    {
        $users = User::query()
            ->when($this->search, function($q) {
                $q->where('name', 'like', '%'.$this->search.'%')
                  ->orWhere('email', 'like', '%'.$this->search.'%');
            })
            ->orderBy('name', 'asc')
            ->paginate(10);

        // CORREÇÃO: Usar o nome exato do seu arquivo de view
        return view('livewire.buscar-usuarios', [
            'users' => $users
        ]);
    }
}