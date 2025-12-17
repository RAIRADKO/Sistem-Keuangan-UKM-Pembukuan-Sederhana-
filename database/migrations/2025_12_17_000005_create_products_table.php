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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->foreignId('store_id')->constrained()->onDelete('cascade');
            $table->foreignId('category_id')->nullable()->constrained('product_categories')->onDelete('set null');
            $table->string('name');
            $table->string('sku')->nullable();
            $table->decimal('purchase_price', 15, 2)->default(0); // Harga Beli
            $table->decimal('selling_price', 15, 2)->default(0);  // Harga Jual
            $table->integer('stock_quantity')->default(0);
            $table->integer('min_stock_alert')->default(0);
            $table->text('description')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();

            $table->index(['store_id', 'name']);
            $table->index(['store_id', 'sku']);
            $table->index(['store_id', 'category_id']);
            $table->index(['store_id', 'is_active']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
