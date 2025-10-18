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
            $table->json('name');
            $table->json('description')->nullable();
            $table->float('before_price',8,2)->nullable();
            $table->float('after_price',8,2);
            $table->string('image')->nullable();
            $table->foreignId('service_provider_id')->constrained('service_providers','id')->cascadeOnDelete();
            $table->foreignId('product_category_id')->nullable()->constrained('product_categories','id')->nullOnDelete();
            $table->timestamps();
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
