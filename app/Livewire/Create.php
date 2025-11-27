<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Product; // Importe o modelo Product
use App\Models\Category; // <--- NOVO: Importe o modelo Category
use Illuminate\View\View;
use Livewire\WithFileUploads; // Se você estiver fazendo upload de imagens

class Create extends Component
{
    use WithFileUploads; // Habilita o upload de arquivos no Livewire

    // Propriedades para os campos do formulário
    public $name;
    public $description;
    public $price;
    public $stock_quantity;
    public $category_id;
    public $image; // Para o upload da imagem

    // Regras de validação
    protected $rules = [
        'name' => 'required|string|max:255',
        'description' => 'nullable|string|max:1000',
        'price' => 'required|numeric|min:0',
        'stock_quantity' => 'required|integer|min:0',
        'category_id' => 'required|exists:categories,id', // Verifica se a categoria existe
        'image' => 'nullable|image|max:1024', // 1MB Max
    ];

    // Mensagens de validação personalizadas (opcional)
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


    // Método para salvar o novo produto
    public function saveProduct()
    {
        $this->validate(); // Roda a validação

        $imagePath = null;
        if ($this->image) {
            // Armazena a imagem no disco 'public' (configurado em config/filesystems.php)
            $imagePath = $this->image->store('products', 'public');
        }

        Product::create([
            'name' => $this->name,
            'description' => $this->description,
            'price' => $this->price,
            'stock_quantity' => $this->stock_quantity,
            'category_id' => $this->category_id,
            'image_path' => $imagePath, // Salva o caminho da imagem
        ]);

        session()->flash('success', 'Produto criado com sucesso!'); // Mensagem flash
        $this->reset(); // Limpa os campos do formulário após o envio
        return redirect()->route('admin.produtos.index'); // Redireciona para a lista de produtos
    }


    public function render(): View
    {
        // <--- NOVO: Busque as categorias aqui
        $categorias = Category::orderBy('name')->get(); // Busca todas as categorias ordenadas por nome

        // Passe a variável $categorias para a view
        return view('livewire.create', [
            'categorias' => $categorias, // <--- NOVO: Passando as categorias para a view
        ]);
    }
}