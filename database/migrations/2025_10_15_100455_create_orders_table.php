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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();

            $table->foreignId('user_id')->nullable()->constrained('users','id')->nullOnDelete();
            $table->string('user_name');
            $table->string('user_phone_number');

            $table->foreignId('service_provider_id')->constrained('service_providers','id')->restrictOnDelete();
            $table->json('service_provider_name');

            $table->foreignId('product_id')->nullable()->constrained('products','id')->nullOnDelete();
            $table->json('product_name');
            $table->integer('product_price');

            $table->foreignId('cashier_id')->nullable()->constrained('users','id')->nullOnDelete();
            $table->string('cashier_name');

            $table->boolean('nafad_confirmation')->default(false);
            $table->text('nafad_confirmation_id')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
