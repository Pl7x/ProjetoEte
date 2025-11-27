<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {


        // --- ADICIONE ESTA PARTE AQUI ---
        // Chama o seeder que cria as categorias (Proteínas, etc.)
        $this->call([
            CategorySeeder::class,
        ]);
        // --------------------------------
    }
}