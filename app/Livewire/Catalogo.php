<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Collection;
// use App\Models\Produto; // Descomente quando tiver o Model e o Banco criados

class Catalogo extends Component
{
    // Filtros
    public $search = '';
    public $categoria = null;
    public $minPrice = null;
    public $maxPrice = null;
    public $selectedBrands = [];
    public $sort = 'relevancia';

    public function updatedSearch() { $this->resetPageIfAvailable(); }
    public function updatedCategoria() { $this->resetPageIfAvailable(); }

    public function resetFilters()
    {
        $this->reset(['search', 'categoria', 'minPrice', 'maxPrice', 'selectedBrands', 'sort']);
    }

    public function addToCart($id)
    {
        // No modo Mock, apenas simulamos o sucesso
        $this->dispatch('produto-adicionado', message: "Produto adicionado ao carrinho com sucesso!");
    }

    private function resetPageIfAvailable()
    {
        // $this->resetPage();
    }

    public function render()
    {
        // --- MODO 1: DADOS FICTÍCIOS (Para testar sem banco de dados) ---
        // Use isto agora enquanto não cria as tabelas
        $produtos = $this->getMockData();

        // --- MODO 2: BANCO DE DADOS REAL (Descomente depois) ---
        /*
        $query = \App\Models\Produto::query();

        if ($this->search) $query->where('nome', 'like', '%' . $this->search . '%');
        if ($this->categoria) $query->where('categoria', $this->categoria);
        if ($this->minPrice) $query->where('preco', '>=', $this->minPrice);
        if ($this->maxPrice) $query->where('preco', '<=', $this->maxPrice);
        if (!empty($this->selectedBrands)) $query->whereIn('marca', $this->selectedBrands);

        $query->when($this->sort === 'price_asc', fn($q) => $q->orderBy('preco', 'asc'))
              ->when($this->sort === 'price_desc', fn($q) => $q->orderBy('preco', 'desc'))
              ->when($this->sort === 'newest', fn($q) => $q->orderBy('created_at', 'desc'))
              ->when($this->sort === 'relevancia', fn($q) => $q->inRandomOrder());

        $produtos = $query->get();
        */

        return view('livewire.catalogo', [
            'produtos' => $produtos
        ]);
    }

    /**
     * Gera dados falsos para visualização imediata
     */
    private function getMockData()
    {
        $items = collect([
            [
                'id' => 1, 'nome' => 'Whey Protein 100% Pure', 'categoria' => 'Proteínas',
                'marca' => 'Integralmédica', 'preco' => 119.90, 'preco_antigo' => 149.90,
                'desconto' => 20, 'imagem' => 'https://via.placeholder.com/300x300?text=Whey+Protein'
            ],
            [
                'id' => 2, 'nome' => 'Creatina Monohidratada 300g', 'categoria' => 'Creatinas',
                'marca' => 'Max Titanium', 'preco' => 89.90, 'preco_antigo' => null,
                'desconto' => null, 'imagem' => 'https://via.placeholder.com/300x300?text=Creatina'
            ],
            [
                'id' => 3, 'nome' => 'Pré-Treino Haze Hardcore', 'categoria' => 'Pré-Treinos',
                'marca' => 'Dux Nutrition', 'preco' => 159.90, 'preco_antigo' => 189.90,
                'desconto' => 15, 'imagem' => 'https://via.placeholder.com/300x300?text=Pre+Treino'
            ],
            [
                'id' => 4, 'nome' => 'Multivitamínico Daily', 'categoria' => 'Vitaminas',
                'marca' => 'SuppStore Nutrition', 'preco' => 49.90, 'preco_antigo' => null,
                'desconto' => null, 'imagem' => 'https://via.placeholder.com/300x300?text=Vitamina'
            ],
            [
                'id' => 5, 'nome' => 'Whey Gold Standard', 'categoria' => 'Proteínas',
                'marca' => 'Optimum Nutrition', 'preco' => 299.90, 'preco_antigo' => 350.00,
                'desconto' => 14, 'imagem' => 'https://via.placeholder.com/300x300?text=Gold+Standard'
            ],
        ]);

        // Simula a lógica de filtragem do banco de dados no array
        return $items->filter(function($item) {
            if ($this->search && stripos($item['nome'], $this->search) === false) return false;
            if ($this->categoria && $item['categoria'] !== $this->categoria) return false;
            if ($this->minPrice && $item['preco'] < $this->minPrice) return false;
            if ($this->maxPrice && $item['preco'] > $this->maxPrice) return false;
            if (!empty($this->selectedBrands) && !in_array($item['marca'], $this->selectedBrands)) return false;
            return true;
        })->sortBy(function($item) {
            if ($this->sort === 'price_asc') return $item['preco'];
            if ($this->sort === 'price_desc') return -$item['preco'];
            return $item['id'];
        })->values();
    }
}
