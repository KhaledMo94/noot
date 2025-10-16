<?php

use App\Models\Package;
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
        Schema::create('service_providers', function (Blueprint $table) {
            $table->id();
            $table->json('name');
            $table->json('description')->nullable();
            $table->foreignId('category_id')->nullable()
                ->constrained('categories','id')
                ->nullOnDelete();
            $table->foreignId('moderator_id')->constrained('users','id')->cascadeOnDelete();
            $table->enum('status',['active','inactive'])->default('active');
            $table->text('image')->nullable();
            $table->date('free_trail_start_date')->nullable();
            $table->date('free_trail_end_date')->nullable();
            $table->json('options')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('service_providers');
    }
};
