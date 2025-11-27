<?php

use App\Http\Controllers\Admin\ProductController;
use Illuminate\Container\Attributes\Auth;
use Illuminate\Support\Facades\Auth as FacadesAuth;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('home');
})->name('home');

Route::get('/admin', function () {
    return view('login');
})->name('login');


Route::get('/registrar', function () {
    return view('registrar');
})->name('registrar');

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


Route::middleware('auth')->group(function () {
    Route::get('/painel', function () {
        return view('admin.dashboard');
    })->name('painel');

    Route::get('/logout', function () {
        FacadesAuth::logout();
        return redirect()->route('login');
    })->name('logout');

    Route::get('/produtos/criar', [ProductController::class, 'create'])->name('produtos.create');

    // 2. Salvar novo produto (POST)
    Route::post('/produtos', [ProductController::class, 'store'])->name('produtos.store');

    // 3. Listar produtos (GET)
    Route::get('/produtos', [ProductController::class, 'index'])->name('produtos');

    Route::get('/usuarios', function () {
        return view('admin.usuario');
    })->name('usuarios');

    Route::get('/pedidos', function () {
        return view('admin.pedidos');
    })->name('pedidos');

    Route::get('/relatorio', function () {
        return view('admin.relatorios');
    })->name('relatorio');

    Route::get('/buscar', function () {
        return view('BuscarUsuarios');
    })->name('buscar');
});

