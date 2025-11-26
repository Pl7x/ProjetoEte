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
        // MUDANÇA 1: Nome da tabela para 'products' (inglês padrão)
        Schema::create('products', function (Blueprint $table) {
            $table->id();

            // MUDANÇA 2: Chave estrangeira padrão.
            // Como a tabela agora se chama 'products' e a outra 'categories',
            // o Laravel entende essa linha automaticamente sem precisar de mais nada.
            $table->foreignId('category_id')->constrained()->onDelete('cascade');

            // --- INFORMAÇÕES BÁSICAS (Nomes em Inglês) ---
            $table->string('name'); // Antes: nome
            $table->string('slug')->unique();
            $table->text('description')->nullable(); // Antes: descricao

            // --- PREÇOS ---
            $table->decimal('price', 10, 2); // Antes: preco
            $table->decimal('old_price', 10, 2)->nullable(); // Antes: preco_antigo

            // --- IMAGEM E ESTOQUE ---
            // Mantive nullable conforme seu envio, mas lembre que no controller está 'required' para criar.
            $table->string('image_path')->nullable(); // Antes: caminho_imagem
            $table->integer('stock_quantity')->default(0); // Antes: quantidade_estoque

            // --- MARKETING ---
            $table->string('badge_text')->nullable(); // Antes: texto_etiqueta
            $table->string('badge_color')->default('primary'); // Antes: cor_etiqueta

            // --- CONTROLE (Booleanos padrão usam 'is_') ---
            $table->boolean('is_active')->default(true); // Antes: ativo
            $table->boolean('is_featured')->default(false); // Antes: destaque

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // MUDANÇA 3: Nome da tabela ao apagar
        Schema::dropIfExists('products');
    }
};