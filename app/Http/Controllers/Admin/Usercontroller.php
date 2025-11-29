<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class Usercontroller extends Controller
{
    public function index()
    {
        return view('admin.usuario');
    }
    public function create()
    {
        return view('admin.criar-usuario');
    }
    public function edit(User $user)
    {
        return view('admin.criar-usuario', [
            'user' => $user
        ]);
    }

}
