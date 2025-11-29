<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;

class Usercontroller extends Controller
{
    public function index()
    {
        return view('admin.usuario'); // Chama a tela da lista
    }

    public function create()
    {
        return view('admin.criar-usuario', ['user' => null]); // Tela de criar (user vazio)
    }

    public function edit(User $user)
    {
        return view('admin.criar-usuario', ['user' => $user]); // Tela de criar (com dados do user)
    }
}