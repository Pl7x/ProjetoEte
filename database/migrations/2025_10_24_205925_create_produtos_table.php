<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->foreignId('category_id')->constrained()->onDelete('cascade');

            $table->string('name');
            $table->string('slug')->unique();
            $table->text('description')->nullable();

            $table->decimal('price', 10, 2);
            $table->decimal('old_price', 10, 2)->nullable();

            // MUDANÇA: Usamos longText para guardar o Base64 da imagem inteira
            $table->longText('image_data')->nullable(); 
            $table->integer('stock_quantity')->default(0);

            $table->string('badge_text')->nullable();
            $table->string('badge_color')->default('primary');

            $table->boolean('is_active')->default(true);
            $table->boolean('is_featured')->default(false);

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};