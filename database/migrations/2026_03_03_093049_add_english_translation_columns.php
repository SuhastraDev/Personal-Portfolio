<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Portfolios
        Schema::table('portfolios', function (Blueprint $table) {
            $table->string('title_en')->nullable()->after('title');
            $table->text('description_en')->nullable()->after('description');
            $table->string('meta_title_en')->nullable()->after('meta_title');
            $table->text('meta_description_en')->nullable()->after('meta_description');
        });

        // Products
        Schema::table('products', function (Blueprint $table) {
            $table->string('title_en')->nullable()->after('title');
            $table->text('description_en')->nullable()->after('description');
            $table->text('features_en')->nullable()->after('features');
            $table->string('meta_title_en')->nullable()->after('meta_title');
            $table->text('meta_description_en')->nullable()->after('meta_description');
        });

        // Services
        Schema::table('services', function (Blueprint $table) {
            $table->string('title_en')->nullable()->after('title');
            $table->text('description_en')->nullable()->after('description');
        });

        // Product Categories
        Schema::table('product_categories', function (Blueprint $table) {
            $table->string('name_en')->nullable()->after('name');
        });

        // Portfolio Categories
        Schema::table('portfolio_categories', function (Blueprint $table) {
            $table->string('name_en')->nullable()->after('name');
        });

        // Settings (for about_bio, hero texts, etc.)
        Schema::table('settings', function (Blueprint $table) {
            $table->text('value_en')->nullable()->after('value');
        });
    }

    public function down(): void
    {
        Schema::table('portfolios', function (Blueprint $table) {
            $table->dropColumn(['title_en', 'description_en', 'meta_title_en', 'meta_description_en']);
        });

        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn(['title_en', 'description_en', 'features_en', 'meta_title_en', 'meta_description_en']);
        });

        Schema::table('services', function (Blueprint $table) {
            $table->dropColumn(['title_en', 'description_en']);
        });

        Schema::table('product_categories', function (Blueprint $table) {
            $table->dropColumn('name_en');
        });

        Schema::table('portfolio_categories', function (Blueprint $table) {
            $table->dropColumn('name_en');
        });

        Schema::table('settings', function (Blueprint $table) {
            $table->dropColumn('value_en');
        });
    }
};
