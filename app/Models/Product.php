<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'category_id',
        'name',
        'slug',
        'description',
        'price',
        'image_data', // Alterado de image_path para image_data
        'stock_quantity',
        'is_active',
        'is_featured',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}