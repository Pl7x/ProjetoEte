<?php

namespace App\Livewire;

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
        return view('livewire.buscar-usuarios');
    }
}
