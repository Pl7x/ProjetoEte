<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Product;
use App\Models\Category;
use Illuminate\View\View;
use Livewire\WithFileUploads;
use Illuminate\Support\Str; // <--- 1. IMPORTANTE: Importar a classe Str

class Create extends Component
{
    use WithFileUploads;

    public $name;
    public $description;
    public $price;
    public $stock_quantity;
    public $category_id;
    public $image;

    protected $rules = [
        'name' => 'required|string|max:255',
        'description' => 'nullable|string|max:1000',
        'price' => 'required|numeric|min:0',
        'stock_quantity' => 'required|integer|min:0',
        'category_id' => 'required|exists:categories,id',
        'image' => 'nullable|image|max:1024',
    ];

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

    public function saveProduct()
    {
        $this->validate();

        $imagePath = null;
        if ($this->image) {
            $imagePath = $this->image->store('products', 'public');
        }

        // <--- 2. CORREÇÃO: Gerar o Slug aqui
        $slug = Str::slug($this->name);

        // Se quiser garantir que o slug seja único (caso já exista outro produto com mesmo nome)
        // pode-se adicionar um contador, mas para começar o básico funciona.

        Product::create([
            'name' => $this->name,
            'slug' => $slug, // <--- Adicionado o campo slug
            'description' => $this->description,
            'price' => $this->price,
            'stock_quantity' => $this->stock_quantity,
            'category_id' => $this->category_id,
            'image_path' => $imagePath,
            'is_active' => true, // Opcional: define como ativo por padrão ao criar
            'is_featured' => false,
        ]);

        session()->flash('success', 'Produto criado com sucesso!');
        $this->reset();
        
        // Verifique se o nome da sua rota é 'produtos' ou 'admin.produtos.index' no web.php
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