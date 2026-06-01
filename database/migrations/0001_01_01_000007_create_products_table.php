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

            $table->string('sku')->unique();
            $table->string('name');
            $table->text('description')->nullable();

            $table->unsignedBigInteger('category_id');
            $table->unsignedBigInteger('supplier_id');

            $table->index('category_id');
            $table->index('supplier_id');

            $table->foreign('category_id', 'products_category_id_foreign')
                ->references('id')
                ->on('categories')
                ->onDelete('cascade');

            $table->foreign('supplier_id', 'products_supplier_id_foreign')
                ->references('id')
                ->on('suppliers')
                ->onDelete('cascade');


            $table->unsignedInteger('stock')->default(0)->index();
            $table->unsignedInteger('reorder_level')->default(0);

            $table->decimal('purchase_price', 12, 2)->default(0);
            $table->decimal('sale_price', 12, 2)->default(0);

            $table->timestamps();
            $table->softDeletes();

            $table->index(['name']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};

