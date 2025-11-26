<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    // Não precisa mais de $table = 'produtos';

    // Atualizado para os nomes em inglês das colunas
    protected $fillable = [
        'category_id',
        'name',
        'slug',
        'description',
        'price',
        'image_path',
        'stock_quantity',
        'is_active',
        'is_featured',
    ];

    public function category()
    {
        // Não precisa mais explicar as chaves. O padrão funciona.
        return $this->belongsTo(Category::class);
    }
}