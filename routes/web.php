<?php

use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\Usercontroller; // Importação corrigida para Admin
use App\Http\Controllers\CatalogoController; // Importação do Catálogo
use Illuminate\Support\Facades\Auth as FacadesAuth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Rotas Públicas
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return view('home');
})->name('home');

Route::get('/admin', function () {
    return view('login');
})->name('login');

Route::get('/sobre', function () {
    return view('sobre');
})->name('sobre');

Route::get('/catalogo', function () {
    return view('catalogo');
})->name('catalogo');

Route::get('/trocas', function () {
    return view('trocas');
})->name('trocas');

Route::get('/politicas', function () {
    return view('politicas');
})->name('politicas');


/*
|--------------------------------------------------------------------------
| Rotas Protegidas (Painel Admin)
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->group(function () {

    Route::get('/painel', function () {
        return view('admin.dashboard');
    })->name('painel');

    Route::get('/logout', function () {
        FacadesAuth::logout();
        return redirect()->route('login');
    })->name('logout');

    // --- Rotas de Produtos ---
    
    // 1. Listagem
    Route::get('/produtos', [ProductController::class, 'index'])->name('produtos');

    // 2. Criar (Formulário e Ação)
    Route::get('/produtos/criar', [ProductController::class, 'create'])->name('produtos.create');
    Route::post('/produtos', [ProductController::class, 'store'])->name('produtos.store');

    // 3. Editar (Formulário e Ação)
    // Importante: Aponta para o método 'edit' do Controller, que reutiliza a view 'create'
    Route::get('/produtos/{product}/editar', [ProductController::class, 'edit'])->name('produtos.edit');
    Route::put('/produtos/{product}', [ProductController::class, 'update'])->name('produtos.update');

    // 4. Apagar
    Route::delete('/produtos/{product}', [ProductController::class, 'destroy'])->name('produtos.destroy');


    // --- Rotas de Usuários ---
    
    Route::get('/usuarios', [Usercontroller::class, 'index'])->name('usuarios');
    Route::get('/usuarios/novo', [Usercontroller::class, 'create'])->name('usuarios.novo');


    // --- Outras Rotas do Admin ---

    Route::get('/pedidos', function () {
        return view('admin.pedidos');
    })->name('pedidos');

    Route::get('/relatorio', function () {
        return view('admin.relatorios');
    })->name('relatorio');

});