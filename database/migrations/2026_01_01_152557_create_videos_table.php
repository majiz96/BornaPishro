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
        Schema::create('videos', function (Blueprint $table) {

            $table->id();
            $table->string('title');
            $table->text('description')->nullable();
            $table->string('aparat')->nullable();
            $table->string('youtube')->nullable();
            $table->string('priority')->default('آپارات');
            $table->integer('show')->default(0);
            $table->morphs('videoable');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('videos');
    }
};
