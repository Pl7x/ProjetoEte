<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Product;
use App\Models\Category;
// use App\Models\Brand; // Se tiver o model Brand

class CatalogoProdutos extends Component
{
    use WithPagination;

    // Filtros existentes
    public $search = '';
    public $sort = 'relevancia'; // Define 'relevancia' como o padrão inicial
    public $categoryFilter = null;
    public $minPrice = null;
    public $maxPrice = null;
    // public $selectedBrands = []; // Se for usar marcas

    // NOVO: Propriedade para armazenar o ID do produto selecionado para a modal
    public $selectedProductId = null;

    // Resetar paginação ao filtrar
    public function updatingSearch() { $this->resetPage(); }
    public function updatingCategoryFilter() { $this->resetPage(); }
    public function updatingSort() { $this->resetPage(); }
    public function updatingMinPrice() { $this->resetPage(); }
    public function updatingMaxPrice() { $this->resetPage(); }
    // public function updatingSelectedBrands() { $this->resetPage(); }

    // Método para limpar filtros
    public function resetFilters()
    {
        // O método reset() volta as propriedades para seus valores padrão definidos no início da classe.
        // Isso limpará a busca, categoria, preços e voltará o sort para 'relevancia'.
        $this->reset(['search', 'categoryFilter', 'sort', 'minPrice', 'maxPrice']);

        // Se usar marcas, adicione na lista:
        // $this->reset(['search', 'categoryFilter', 'sort', 'minPrice', 'maxPrice', 'selectedBrands']);

        $this->resetPage();
    }

    // NOVO: Método chamado ao clicar no botão "Comprar"
    public function openQuickView($productId)
    {
        // 1. Define o ID do produto selecionado. Isso fará com que o componente
        //    'product-quick-view' seja renderizado na view.
        $this->selectedProductId = $productId;

        // 2. Dispara um evento para o navegador (JS) abrir a modal do Bootstrap.
        $this->dispatch('show-quick-view-modal');
    }

    // Opcional: Método para resetar o ID quando a modal fechar
    // public function closeQuickView() { $this->selectedProductId = null; }
    public function addToCart($productId)
    {
        $product = Product::find($productId);

        if (!$product) {
            return;
        }

        $cart = session()->get('cart', []);

        // Se o produto já existe no carrinho, aumenta a quantidade
        if (isset($cart[$productId])) {
            $cart[$productId]['quantity']++;
        } else {
            // Se não existe, adiciona novo
            $cart[$productId] = [
                'name' => $product->name,
                'quantity' => 1,
                'price' => $product->price,
                'image' => $product->image_path
            ];
        }

        session()->put('cart', $cart);

        // Dispara evento para o componente do carrinho atualizar e abre o menu lateral
        $this->dispatch('cart-updated'); 
        $this->dispatch('open-cart'); // Vamos criar esse script abaixo
        
        // Feedback visual (opcional)
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
            // Garante que é um número e filtra maior ou igual
            $query->where('price', '>=', (float) $this->minPrice);
        }
        if ($this->maxPrice) {
             // Garante que é um número e filtra menor ou igual
            $query->where('price', '<=', (float) $this->maxPrice);
        }

        // 4. Filtro de Marcas (Se houver)
        // if (!empty($this->selectedBrands)) {
        //      $query->whereIn('brand_id', $this->selectedBrands);
        // }

        // 5. Aplica a ordenação baseada na propriedade $sort
        $query->when($this->sort === 'price_asc', fn($q) => $q->orderBy('price', 'asc'))
              ->when($this->sort === 'price_desc', fn($q) => $q->orderBy('price', 'desc'))
              // 'relevancia' é o padrão (mais recentes primeiro se não houver busca específica)
              ->when($this->sort === 'relevancia', fn($q) => $q->orderBy('created_at', 'desc'));


        $products = $query->paginate(12);
        $categories = Category::all();
        // $brands = Brand::all(); // Se houver

        return view('livewire.catalogo-produtos', [
            'products' => $products,
            'categories' => $categories,
            // 'todasMarcas' => $brands, // Se houver
        ]);
    }
}
