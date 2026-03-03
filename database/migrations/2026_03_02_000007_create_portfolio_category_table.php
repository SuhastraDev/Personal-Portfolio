<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('portfolio_category', function (Blueprint $table) {
            $table->foreignId('portfolio_id')->constrained()->cascadeOnDelete();
            $table->foreignId('category_id')->constrained('portfolio_categories')->cascadeOnDelete();
            $table->primary(['portfolio_id', 'category_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('portfolio_category');
    }
};
