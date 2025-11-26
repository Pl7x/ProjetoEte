<?php

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

    Route::get('/produtos', function () {
        return view('admin.produtos');
    })->name('produtos');

    Route::get('/usuarios', function () {
        return view('admin.usuario');
    })->name('usuarios');

    Route::get('/pedidos', function () {
        return view('admin.pedidos');
    })->name('pedidos');

    Route::get('/relatorio', function () {
        return view('admin.relatorios');
    })->name('relatorio');

});

