<?php

namespace App\Http\Controllers;

use App\Models\Product; // Importa o modelo Product
use Illuminate\Http\Request;

class CatalogoController extends Controller
{
    // Método que será chamado quando a rota do catálogo for acessada
    public function index()
    {
        // Busca todos os produtos do banco de dados e os pagina (12 produtos por página)
        $products = Product::paginate(12);

        // Retorna a view 'catalogo', passando a variável $products para ela
        return view('catalogo', compact('products'));
    }
}