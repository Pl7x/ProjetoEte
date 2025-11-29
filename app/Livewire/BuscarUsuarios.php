<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\User;
use Illuminate\Support\Facades\Auth; // Para não se excluir a si mesmo

class BuscarUsuarios extends Component
{
    use WithPagination;

    // Filtro de pesquisa
    public $search = '';

    // Variáveis do Modal de Exclusão
    public $userIdToDelete;
    public $userNameToDelete;

    // Reinicia a página ao pesquisar
    public function updatingSearch()
    {
        $this->resetPage();
    }

    // Abre o modal de confirmação
    public function confirmDelete($userId)
    {
        $this->userIdToDelete = $userId;
        $user = User::findOrFail($userId);
        $this->userNameToDelete = $user->name;
        $this->dispatch('show-delete-modal');
    }

    // Efetua a exclusão
    public function deleteUser()
    {
        if ($this->userIdToDelete) {
            // Impede que o usuário exclua a si mesmo
            if ($this->userIdToDelete == Auth::id()) {
                session()->flash('error', 'Você não pode excluir sua própria conta!');
                $this->dispatch('hide-delete-modal');
                return;
            }

            User::destroy($this->userIdToDelete);
            
            session()->flash('success', 'Usuário excluído com sucesso!');
            $this->resetPage();
            $this->dispatch('hide-delete-modal');
            
            // Limpa variáveis
            $this->userIdToDelete = null;
            $this->userNameToDelete = null;
        }
    }

    public function render()
    {
        $users = User::query()
            ->when($this->search, function($query) {
                $query->where('name', 'like', '%' . $this->search . '%')
                      ->orWhere('email', 'like', '%' . $this->search . '%');
            })
            ->orderBy('name', 'asc')
            ->paginate(10);

        return view('livewire.lista-usuarios', [
            'users' => $users
        ]);
    }
}