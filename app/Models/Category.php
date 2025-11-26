<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    // Não precisa mais de $table = 'categorias';

    // Atualizado para os nomes em inglês das colunas
    protected $fillable = [
        'name',
        'slug',
        'image_path'
    ];

    public function products()
    {
        return $this->hasMany(Product::class);
    }
}