<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Product;
use App\Models\Category;
use Illuminate\View\View;
use Livewire\WithFileUploads;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule; // Necessário para a validação ignorar o próprio ID na edição

class Create extends Component
{
    use WithFileUploads;

    public ?Product $product = null; // Armazena o produto se for edição

    public $name;
    public $description;
    public $price;
    public $stock_quantity;
    public $category_id;
    public $image;          // Nova imagem (upload)
    public $existing_image; // Caminho da imagem atual (para preview)

    // Transformamos as regras em método para usar $this->product
    protected function rules()
    {
        return [
            'name' => [
                'required', 
                'string', 
                'max:255', 
                // Ignora o ID do produto atual se estiver editando, para não dar erro de "nome já existe"
                Rule::unique('products', 'name')->ignore($this->product?->id)
            ],
            'description' => 'nullable|string|max:1000',
            'price' => 'required|numeric|min:0',
            'stock_quantity' => 'required|integer|min:0',
            'category_id' => 'required|exists:categories,id',
            'image' => 'nullable|image|max:1024',
        ];
    }

    protected $messages = [
        'name.required' => 'O nome do produto é obrigatório.',
        'price.required' => 'O preço é obrigatório.',
        'price.numeric' => 'O preço deve ser um número.',
        'price.min' => 'O preço não pode ser negativo.',
        'stock_quantity.required' => 'O estoque é obrigatório.',
        'stock_quantity.integer' => 'O estoque deve ser um número inteiro.',
        'stock_quantity.min' => 'O estoque não pode ser negativo.',
        'category_id.required' => 'A categoria é obrigatória.',
        'category_id.exists' => 'A categoria selecionada é inválida.',
        'image.image' => 'O arquivo deve ser uma imagem.',
        'image.max' => 'A imagem não pode ser maior que 1MB.',
    ];

    // O método mount prepara o componente (preenche dados se for edição)
    public function mount($product = null)
    {
        if ($product) {
            $this->product = $product;
            $this->name = $product->name;
            $this->description = $product->description;
            $this->price = $product->price;
            $this->stock_quantity = $product->stock_quantity;
            $this->category_id = $product->category_id;
            $this->existing_image = $product->image_path;
        }
    }

    public function saveProduct()
    {
        $this->validate();

        // Define a imagem: começa com a existente (ou null)
        $imagePath = $this->existing_image;

        // Se fez upload de nova imagem, sobrescreve
        if ($this->image) {
            $imagePath = $this->image->store('products', 'public');
        }

        // Gera o Slug
        $slug = Str::slug($this->name);

        if ($this->product) {
            // --- ATUALIZAR (UPDATE) ---
            $this->product->update([
                'name' => $this->name,
                'slug' => $slug,
                'description' => $this->description,
                'price' => $this->price,
                'stock_quantity' => $this->stock_quantity,
                'category_id' => $this->category_id,
                'image_path' => $imagePath,
            ]);
            session()->flash('success', 'Produto atualizado com sucesso!');
        } else {
            // --- CRIAR (CREATE) ---
            Product::create([
                'name' => $this->name,
                'slug' => $slug,
                'description' => $this->description,
                'price' => $this->price,
                'stock_quantity' => $this->stock_quantity,
                'category_id' => $this->category_id,
                'image_path' => $imagePath,
                'is_active' => true,
                'is_featured' => false,
            ]);
            session()->flash('success', 'Produto criado com sucesso!');
        }

        $this->reset(); 
        return redirect()->route('produtos'); 
    }

    public function render(): View
    {
        $categorias = Category::orderBy('name')->get();

        return view('livewire.create', [
            'categorias' => $categorias,
        ]);
    }
}