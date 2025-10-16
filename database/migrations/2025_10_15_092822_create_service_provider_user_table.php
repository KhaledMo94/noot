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
        Schema::create('service_provider_user', function (Blueprint $table) {
            $table->foreignId('user_id')->constrained('users','id')->cascadeOnDelete();
            $table->foreignId('service_provider_id')->constrained('service_providers','id')->cascadeOnDelete();
            $table->primary([
                'service_provider_id','user_id',
            ]);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('service_provider_user');
    }
};
