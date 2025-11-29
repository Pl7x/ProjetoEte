<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    public function index()
    {
        // Carrega produtos com a categoria para evitar queries N+1
        $produtos = Product::with('category')->latest()->paginate(10);
        return view('admin.produtos.lista', compact('produtos'));
    }

    public function create()
    {
        $categorias = Category::all();
        // Envia 'produto' como null para a view saber que é um cadastro novo
        return view('admin.produtos.create', [
            'categorias' => $categorias, 
            'produto' => null
        ]);
    }

    // Este método é usado se o formulário for HTML padrão (sem Livewire submit)
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'price' => 'required|numeric|min:0',
            'image_path' => 'required|image|mimes:jpeg,png,jpg,webp|max:2048',
            'description' => 'nullable|string',
            'stock_quantity' => 'nullable|integer|min:0',
        ]);

        $data = $request->all();
        $data['slug'] = Str::slug($request->name);
        $data['is_active'] = $request->has('is_active') ? 1 : 0;
        $data['is_featured'] = $request->has('is_featured') ? 1 : 0;

        if ($request->hasFile('image_path') && $request->file('image_path')->isValid()) {
            $data['image_path'] = $request->file('image_path')->store('products', 'public');
        }

        Product::create($data);

        return redirect()->route('produtos')->with('success', 'Produto cadastrado com sucesso!');
    }

    // Ajustei o nome do parâmetro para $product para bater com a rota
    public function edit(Product $product)
    {
        $categorias = Category::all();
        // Reutiliza a view 'create', mas enviando os dados do produto
        return view('admin.produtos.create', [
            'categorias' => $categorias, 
            'produto' => $product
        ]);
    }

    public function update(Request $request, Product $product)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'price' => 'required|numeric|min:0',
            'image_path' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'description' => 'nullable|string',
            'stock_quantity' => 'nullable|integer|min:0',
        ]);

        $data = $request->all();
        $data['slug'] = Str::slug($request->name);
        $data['is_active'] = $request->has('is_active') ? 1 : 0;
        $data['is_featured'] = $request->has('is_featured') ? 1 : 0;

        if ($request->hasFile('image_path') && $request->file('image_path')->isValid()) {
            // Apaga imagem antiga
            if ($product->image_path && Storage::disk('public')->exists($product->image_path)) {
                Storage::disk('public')->delete($product->image_path);
            }
            $data['image_path'] = $request->file('image_path')->store('products', 'public');
        } else {
            // Remove o campo para não sobrescrever com null se não enviou imagem nova
            unset($data['image_path']);
        }

        $product->update($data);

        return redirect()->route('produtos')->with('success', 'Produto atualizado com sucesso!');
    }

    public function destroy(Product $product)
    {
        if ($product->image_path && Storage::disk('public')->exists($product->image_path)) {
            Storage::disk('public')->delete($product->image_path);
        }
        $product->delete();
        return redirect()->route('produtos')->with('success', 'Produto excluído com sucesso!');
    }
}