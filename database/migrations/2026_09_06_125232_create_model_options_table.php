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
        Schema::create('model_options', function (Blueprint $table) {

            $table->id();
            $table->foreignId('option_id')->constrained('options')->cascadeOnDelete();
            $table->morphs('optionable');

            $table->unique(['option_id','optionable_id', 'optionable_type']);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('model_options');
    }
};
