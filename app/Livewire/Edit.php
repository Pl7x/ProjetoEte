<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Product;
use App\Models\Category;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class Edit extends Component
{
    use WithFileUploads;

    // REMOVA OU COMENTE A PROPRIEDADE $layout
    // protected $layout = 'layouts.admin'; // <-- REMOVA ESTA LINHA

    public Product $product;
    public $name;
    public $description;
    public $price;
    public $stock_quantity;
    public $category_id;
    public $new_image;
    public $existing_image_path;

    public $categorias;

    // O método mount ainda funciona da mesma forma
    public function mount(Product $product)
    {
        $this->product = $product;
        $this->fill($product->only('name', 'description', 'price', 'stock_quantity', 'category_id'));
        $this->existing_image_path = $product->image_path;
        $this->categorias = Category::all();
    }

    // Regras de validação
    protected function rules()
    {
        return [
            'name' => ['required', 'string', 'max:255',
                       Rule::unique('products')->ignore($this->product->id)],
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0.01',
            'stock_quantity' => 'required|integer|min:0',
            'category_id' => 'required|exists:categories,id',
            'new_image' => 'nullable|image|max:1024',
        ];
    }

    // Método para atualizar o produto
    public function updateProduct()
    {
        $this->validate();

        if ($this->new_image) {
            if ($this->existing_image_path) {
                Storage::disk('public')->delete($this->existing_image_path);
            }
            $newImagePath = $this->new_image->store('produtos', 'public');
            $this->product->image_path = $newImagePath;
        }

        $this->product->name = $this->name;
        $this->product->description = $this->description;
        $this->product->price = $this->price;
        $this->product->stock_quantity = $this->stock_quantity;
        $this->product->category_id = $this->category_id;

        $this->product->save();

        session()->flash('success', 'Produto atualizado com sucesso!');
        $this->reset('new_image');
        $this->existing_image_path = $this->product->image_path;
    }

    // O método render agora apenas retorna a view do componente, sem layout
    public function render()
    {
        return view('livewire.edit', [
            'categorias' => $this->categorias
        ]);
    }
}