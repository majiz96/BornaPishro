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
        Schema::create('articles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('writer_id')->constrained('users');
            $table->foreignId('editor_id')->nullable()->constrained('users');
            $table->foreignId('category_id')->constrained('categories');
            $table->foreignId('filter_id')->nullable()->constrained('filters');
            $table->string('title');
            $table->text('intro');
            $table->longText('content');
            $table->string('cover');
            $table->boolean('show')->default(false);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('articles');
    }
};
