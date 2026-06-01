<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('inventory_movements', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('product_id');
            $table->unsignedBigInteger('user_id')->nullable();

            $table->index('product_id');
            $table->index('user_id');

            $table->foreign('product_id', 'inventory_movements_product_id_foreign')
                ->references('id')
                ->on('products')
                ->onDelete('cascade');

            $table->foreign('user_id', 'inventory_movements_user_id_foreign')
                ->references('id')
                ->on('users')
                ->onDelete('set null');


            // Entradas: purchase / restock | Salidas: sale / waste
            $table->string('type', 50);

            // Cantidad positiva; la dirección la determina type
            $table->unsignedInteger('quantity');
            $table->decimal('unit_cost', 12, 2)->default(0);

            $table->string('reference_type')->nullable();
            $table->unsignedBigInteger('reference_id')->nullable();

            $table->text('note')->nullable();

            $table->timestamps();
            $table->index(['type', 'created_at']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('inventory_movements');
    }
};
