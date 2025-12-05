<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Url;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Support\Facades\Auth; 
use App\Models\CartItem; 

class CatalogoProdutos extends Component
{
    use WithPagination;

    // Filtros existentes
    public $search = '';

    public $sort = 'relevancia';

    // Atributo #[Url] para sincronizar com a query string ?categoria=ID
    #[Url(as: 'categoria')] 
    public $categoryFilter = null;

    public $minPrice = null;
    public $maxPrice = null;

    // Propriedade para armazenar o ID do produto selecionado para a modal
    public $selectedProductId = null;

    // Resetar paginação ao filtrar
    public function updatingSearch() { $this->resetPage(); }
    public function updatingCategoryFilter() { $this->resetPage(); }
    public function updatingSort() { $this->resetPage(); }
    public function updatingMinPrice() { $this->resetPage(); }
    public function updatingMaxPrice() { $this->resetPage(); }

    // Método para limpar filtros
    public function resetFilters()
    {
        $this->reset(['search', 'categoryFilter', 'sort', 'minPrice', 'maxPrice']);
        $this->resetPage();
    }

    // Método chamado ao clicar no botão "Comprar" (Visualizar)
    public function openQuickView($productId)
    {
        $this->selectedProductId = $productId;
        $this->dispatch('show-quick-view-modal');
    }

    // Método para adicionar ao carrinho
    public function addToCart($productId)
    {
        $product = Product::find($productId);
        if (!$product) return;

        // SE LOGADO: Salva no Banco de Dados
        if (Auth::guard('client')->check()) {
            $item = CartItem::where('client_id', Auth::guard('client')->id())
                        ->where('product_id', $productId)
                        ->first();
            
            if ($item) {
                $item->increment('quantity');
            } else {
                CartItem::create([
                    'client_id' => Auth::guard('client')->id(),
                    'product_id' => $productId,
                    'quantity' => 1
                ]);
            }
        } 
        // SE VISITANTE: Salva na Sessão
        else {
            $cart = session()->get('cart', []);
            if (isset($cart[$productId])) {
                $cart[$productId]['quantity']++;
            } else {
                $cart[$productId] = [
                    'name' => $product->name,
                    'quantity' => 1,
                    'price' => $product->price,
                    // CORREÇÃO: Usar image_data (Base64) em vez de image_path
                    'image' => $product->image_data 
                ];
            }
            session()->put('cart', $cart);
        }

        // Atualiza os componentes visuais do carrinho
        $this->dispatch('cart-updated'); 
        $this->dispatch('open-cart');
        
        session()->flash('success', 'Produto adicionado!');
    }

    public function render()
    {
        $query = Product::query();

        // 1. Busca
        if ($this->search) {
            $query->where(function ($q) {
                $q->where('name', 'like', '%' . $this->search . '%')
                  ->orWhere('description', 'like', '%' . $this->search . '%');
            });
        }

        // 2. Filtro de Categoria
        if ($this->categoryFilter) {
            $query->where('category_id', $this->categoryFilter);
        }

        // 3. Filtro de Faixa de Preço
        if ($this->minPrice) {
            $query->where('price', '>=', (float) $this->minPrice);
        }
        if ($this->maxPrice) {
            $query->where('price', '<=', (float) $this->maxPrice);
        }

        // 5. Aplica a ordenação baseada na propriedade $sort
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