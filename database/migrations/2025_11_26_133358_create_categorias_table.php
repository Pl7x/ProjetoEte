<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
{
    // Tabela em Inglês
    Schema::create('categories', function (Blueprint $table) {
        $table->id();
        // Colunas em Inglês para bater com o Model e o Seeder
        $table->string('name');         // Mudou de 'nome'
        $table->string('slug')->unique();
        $table->string('image_path');   // Mudou de 'caminho_imagem'
        $table->timestamps();
    });
}

public function down(): void
{
    Schema::dropIfExists('categories'); // MUDOU AQUI TAMBÉM
}
};