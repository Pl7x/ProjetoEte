<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Cria o usuário Admin
        User::factory()->create([
            'name' => 'Pedro Lucas',
            'email' => 'pedro@gmail.com',
            'password' => Hash::make('123456'),
        ]);

        // --- ADICIONE ESTA PARTE AQUI ---
        // Chama o seeder que cria as categorias (Proteínas, etc.)
        $this->call([
            CategorySeeder::class,
        ]);
        // --------------------------------
    }
}