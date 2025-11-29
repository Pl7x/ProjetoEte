<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Product;
use App\Models\Category; // Importar o modelo Category
use Illuminate\View\View;

class Lista extends Component
{
    use WithPagination;

    // --- FILTROS DE PESQUISA ---
    public $search = '';      // Busca por texto (nome)
    public $category_id = ''; // Busca por ID da categoria

    // --- MODAL DE EXCLUSÃO ---
    public $productIdToDelete;
    public $productToDeleteName;

    // Resetar a paginação quando a pesquisa muda
    // Isso evita ficar na página 5 quando o resultado da busca só tem 1 página
    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingCategoryId()
    {
        $this->resetPage();
    }

    public function confirmDelete($productId)
    {
        $this->productIdToDelete = $productId;
        $product = Product::findOrFail($productId);
        $this->productToDeleteName = $product->name;
        $this->dispatch('show-delete-modal');
    }

    public function deleteProduct()
    {
        if ($this->productIdToDelete) {
            Product::destroy($this->productIdToDelete);
            session()->flash('error', 'Produto excluído com sucesso!');
            $this->resetPage();
            $this->dispatch('hide-delete-modal');
            $this->productIdToDelete = null;
            $this->productToDeleteName = null;
        } else {
            session()->flash('error', 'Erro ao tentar excluir: ID não fornecido.');
        }
    }

    public function render(): View
    {
        // Consulta base com filtros aplicados
        $produtos = Product::with('category')
            ->when($this->search, function ($query) {
                // Filtra pelo nome se houver texto na busca
                $query->where('name', 'like', '%' . $this->search . '%');
            })
            ->when($this->category_id, function ($query) {
                // Filtra pela categoria se alguma for selecionada
                $query->where('category_id', $this->category_id);
            })
            ->orderBy('name', 'asc')
            ->paginate(10);

        // Busca todas as categorias para preencher o <select>
        $categories = Category::orderBy('name')->get();

        return view('livewire.lista', [
            'produtos' => $produtos,
            'categories' => $categories, // Passa as categorias para a view
        ]);
    }
}