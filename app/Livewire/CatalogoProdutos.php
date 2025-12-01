<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Product;
use App\Models\Category;
use App\Models\CartItem;
use Illuminate\Support\Facades\Auth;

class CatalogoProdutos extends Component
{
    use WithPagination;

    public $search = '';
    public $sort = 'relevancia';
    public $categoryFilter = null;
    public $minPrice = null;
    public $maxPrice = null;

    public $selectedProductId = null;

    public function updatingSearch() { $this->resetPage(); }
    public function updatingCategoryFilter() { $this->resetPage(); }
    public function updatingSort() { $this->resetPage(); }
    public function updatingMinPrice() { $this->resetPage(); }
    public function updatingMaxPrice() { $this->resetPage(); }

    public function resetFilters()
    {
        $this->reset(['search', 'categoryFilter', 'sort', 'minPrice', 'maxPrice']);
        $this->resetPage();
    }

    public function openQuickView($productId)
    {
        $this->selectedProductId = $productId;
        $this->dispatch('show-quick-view-modal');
    }

    // === MÉTODO ATUALIZADO: Adicionar ao Carrinho ===
    public function addToCart($productId)
    {
        // 1. Verifica se o cliente está logado
        if (!Auth::guard('client')->check()) {

            // AQUI ESTÁ A CORREÇÃO:
            // Em vez de redirecionar ou dar alert, abrimos o Modal de Login (#authModal)
            // Usamos 'getOrCreateInstance' para garantir que funcione mesmo se não foi inicializado ainda
            $this->js("
                var myModalEl = document.getElementById('authModal');
                var modal = bootstrap.Modal.getOrCreateInstance(myModalEl);
                modal.show();
            ");

            return; // Para a execução aqui
        }

        $clientId = Auth::guard('client')->id();

        // 2. Lógica de adicionar/incrementar (igual a antes)
        $cartItem = CartItem::where('client_id', $clientId)
                            ->where('product_id', $productId)
                            ->first();

        if ($cartItem) {
            $cartItem->increment('quantity');
        } else {
            CartItem::create([
                'client_id' => $clientId,
                'product_id' => $productId,
                'quantity' => 1
            ]);
        }

        // 3. Feedback e atualização
        $this->dispatch('cart-updated');
        session()->flash('success', 'Produto adicionado ao carrinho!');
    }

    public function render()
    {
        $query = Product::query();

        if ($this->search) {
            $query->where(function ($q) {
                $q->where('name', 'like', '%' . $this->search . '%')
                  ->orWhere('description', 'like', '%' . $this->search . '%');
            });
        }

        if ($this->categoryFilter) {
            $query->where('category_id', $this->categoryFilter);
        }

        if ($this->minPrice) {
            $query->where('price', '>=', (float) $this->minPrice);
        }
        if ($this->maxPrice) {
            $query->where('price', '<=', (float) $this->maxPrice);
        }

        $query->when($this->sort === 'price_asc', fn($q) => $q->orderBy('price', 'asc'))
              ->when($this->sort === 'price_desc', fn($q) => $q->orderBy('price', 'desc'))
              ->when($this->sort === 'relevancia', fn($q) => $q->orderBy('created_at', 'desc'));

        $products = $query->paginate(12);
        $categories = Category::all();

        return view('livewire.catalogo-produtos', [
            'products' => $products,
            'categories' => $categories,
        ]);
    }
}
