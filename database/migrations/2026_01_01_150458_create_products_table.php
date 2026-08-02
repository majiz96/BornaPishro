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
            $table->foreignId('category_id')->constrained('categories');
            $table->foreignId('brand_id')->nullable()->constrained('brands');
            $table->string('brand_name')->nullable();
            $table->string('name');
            $table->string('fullname')->nullable();
            $table->text('intro')->nullable();
            $table->unsignedInteger('price')->nullable();
            $table->unsignedTinyInteger('discount')->nullable();
            $table->string('image');
            $table->boolean('supply')->default(1);
            $table->boolean('show')->default(false);

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
