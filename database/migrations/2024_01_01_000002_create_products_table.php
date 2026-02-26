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
            $table->foreignId('category_id')->constrained()->onDelete('cascade');
            $table->string('name');
            $table->string('slug')->unique();
            $table->text('description');
            $table->text('short_description')->nullable();
            $table->decimal('price', 10, 2);
            $table->decimal('compare_price', 10, 2)->nullable();
            $table->integer('stock')->default(0);
            $table->string('sku')->unique()->nullable();
            $table->string('image')->nullable();
            $table->json('gallery')->nullable();
            $table->boolean('is_active')->default(true);
            $table->boolean('is_featured')->default(false);
            $table->decimal('average_rating', 3, 2)->default(0);
            $table->integer('reviews_count')->default(0);
            $table->timestamps();
            $table->softDeletes();

            $table->index('category_id');
            $table->index('slug');
            $table->index('is_active');
            $table->index('is_featured');
            $table->index('price');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
