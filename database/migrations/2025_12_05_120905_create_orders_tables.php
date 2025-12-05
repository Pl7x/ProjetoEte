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
    // Tabela do Pedido Geral
    Schema::create('orders', function (Blueprint $table) {
        $table->id();
        $table->unsignedBigInteger('client_id')->nullable(); // Pode ser nulo (visitante)
        $table->string('stripe_session_id')->unique(); // ID do pagamento para segurança
        $table->string('status')->default('pending'); // paid, failed
        $table->decimal('total_price', 10, 2);
        
        // Dados do Cliente (vindos do Stripe)
        $table->string('customer_name')->nullable();
        $table->string('customer_email')->nullable();
        
        // Endereço (vamos salvar tudo num campo de texto/JSON para facilitar)
        $table->text('shipping_address')->nullable(); 
        
        $table->timestamps();
    });

    // Tabela dos Itens (Produtos comprados)
    Schema::create('order_items', function (Blueprint $table) {
        $table->id();
        $table->foreignId('order_id')->constrained()->onDelete('cascade');
        $table->foreignId('product_id')->constrained(); // Relaciona com seus produtos
        $table->integer('quantity');
        $table->decimal('price', 10, 2); // Preço unitário
        $table->timestamps();
    });
}

public function down(): void
{
    Schema::dropIfExists('order_items');
    Schema::dropIfExists('orders');
}
};
