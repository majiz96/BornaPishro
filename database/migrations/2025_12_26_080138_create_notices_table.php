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
        Schema::create('notices', function (Blueprint $table) {

            $table->id();
            $table->string('title');
            $table->text('description');
            $table->string('display');
            $table->string('contact');
            $table->string('style')->nullable();
            $table->foreignId('position_id')->default(4)->constrained('positions');
            $table->boolean('status')->default(false);
            $table->date('expired_at');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('notices');
    }
};
