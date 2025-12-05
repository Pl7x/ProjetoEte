<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Product;
use App\Models\Category;
use Illuminate\View\View;
use Livewire\WithFileUploads;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class Create extends Component
{
    use WithFileUploads;

    public ?Product $product = null;

    public $name;
    public $description;
    public $price;
    public $stock_quantity;
    public $category_id;
    public $image;          
    public $existing_image_data; // Variável renomeada para clareza

    protected function rules()
    {
        return [
            'name' => [
                'required', 'string', 'max:255', 
                Rule::unique('products', 'name')->ignore($this->product?->id)
            ],
            'description' => 'nullable|string|max:1000',
            'price' => 'required|numeric|min:0',
            'stock_quantity' => 'required|integer|min:0',
            'category_id' => 'required|exists:categories,id',
            'image' => 'nullable|image|max:1024', // Máximo 1MB para não estourar o banco
        ];
    }

    public function mount($product = null)
    {
        if ($product) {
            $this->product = $product;
            $this->name = $product->name;
            $this->description = $product->description;
            $this->price = $product->price;
            $this->stock_quantity = $product->stock_quantity;
            $this->category_id = $product->category_id;
            $this->existing_image_data = $product->image_data;
        }
    }

    public function saveProduct()
    {
        $this->validate();

        // 1. Define a imagem inicial (existente ou null)
        $finalImageData = $this->existing_image_data;

        // 2. Se o usuário enviou nova imagem, converte para Base64
        if ($this->image) {
            $mime = $this->image->getMimeType();
            $path = $this->image->getRealPath();
            $content = file_get_contents($path);
            $base64 = base64_encode($content);
            
            // Cria a string data URI completa (ex: data:image/png;base64,.....)
            $finalImageData = "data:{$mime};base64,{$base64}";
        }

        $slug = Str::slug($this->name);
        $data = [
            'name' => $this->name,
            'slug' => $slug,
            'description' => $this->description,
            'price' => $this->price,
            'stock_quantity' => $this->stock_quantity,
            'category_id' => $this->category_id,
            'image_data' => $finalImageData, // Salva o base64
        ];

        if ($this->product) {
            $this->product->update($data);
            session()->flash('success', 'Produto atualizado com sucesso!');
        } else {
            $data['is_active'] = true;
            $data['is_featured'] = false;
            Product::create($data);
            session()->flash('success', 'Produto criado com sucesso!');
        }

        $this->reset(); 
        return redirect()->route('produtos'); 
    }

    public function render(): View
    {
        return view('livewire.create', [
            'categorias' => Category::orderBy('name')->get(),
        ]);
    }
}