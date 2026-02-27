<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('promo_codes', function (Blueprint $table) {
            $table->id();
            $table->string('code')->unique();
            $table->enum('discount_type', ['percent', 'flat']);
            $table->decimal('discount_value', 10, 2);
            $table->decimal('min_price', 12, 2)->default(0);
            $table->string('label');
            $table->string('category')->nullable(); // null = semua kategori
            $table->string('promo_group');
            $table->string('period');
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('promo_codes');
    }
};
