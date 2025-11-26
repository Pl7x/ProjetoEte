<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categoriasParaInserir = ['Proteínas', 'Creatinas', 'Pré-Treinos', 'Vitaminas'];

        foreach ($categoriasParaInserir as $nomeCategoria) {
            Category::updateOrCreate(
                ['slug' => Str::slug($nomeCategoria)],
                [
                    'name' => $nomeCategoria, // MUDOU DE 'nome' PARA 'name'
                    // MUDOU DE 'caminho_imagem' PARA 'image_path'
                    'image_path' => 'https://placehold.co/600x400?text=' . urlencode($nomeCategoria),
                ]
            );
        }
    }
}