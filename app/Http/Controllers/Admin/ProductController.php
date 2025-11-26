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
        $produtos = Product::with('category')->latest()->paginate(10);
        // Mantive o nome da view em PT como você já tinha
        return view('admin.produtos.lista', compact('produtos'));
    }

    public function create()
    {
        $categorias = Category::all();
        return view('admin.produtos.create', compact('categorias'));
    }

    public function store(Request $request)
    {
        // VALIDAÇÃO COM NOMES EM INGLÊS
        $request->validate([
            'name' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id', // Tabela 'categories'
            'price' => 'required|numeric|min:0',
            'image_path' => 'required|image|mimes:jpeg,png,jpg,webp|max:2048',
            'description' => 'nullable|string',
            'stock_quantity' => 'nullable|integer|min:0',
        ]);

        $data = $request->all();
        $data['slug'] = Str::slug($request->name);
        // Checkboxes usando os nomes novos (is_active, is_featured)
        $data['is_active'] = $request->has('is_active') ? 1 : 0;
        $data['is_featured'] = $request->has('is_featured') ? 1 : 0;

        if ($request->hasFile('image_path') && $request->file('image_path')->isValid()) {
            $imagePath = $request->file('image_path')->store('products', 'public'); // Pasta 'products'
            $data['image_path'] = $imagePath;
        }

        Product::create($data);

        return redirect()->route('produtos')->with('success', 'Produto cadastrado com sucesso!');
    }

    public function edit(Product $produto)
    {
        $categorias = Category::all();
        return view('admin.produtos.editar', compact('produto', 'categorias'));
    }

    public function update(Request $request, Product $produto)
    {
        // VALIDAÇÃO COM NOMES EM INGLÊS
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
            // Apaga imagem antiga usando o nome do campo novo
            if ($produto->image_path && Storage::disk('public')->exists($produto->image_path)) {
                Storage::disk('public')->delete($produto->image_path);
            }
            $imagePath = $request->file('image_path')->store('products', 'public');
            $data['image_path'] = $imagePath;
        } else {
            unset($data['image_path']);
        }

        $produto->update($data);

        return redirect()->route('produtos')->with('success', 'Produto atualizado com sucesso!');
    }

    public function destroy(Product $produto)
    {
        if ($produto->image_path && Storage::disk('public')->exists($produto->image_path)) {
            Storage::disk('public')->delete($produto->image_path);
        }
        $produto->delete();
        return redirect()->route('produtos')->with('success', 'Produto excluído com sucesso!');
    }
}