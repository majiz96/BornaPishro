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
        Schema::create('user_notice', function (Blueprint $table) {

            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('notice_id')->constrained()->cascadeOnDelete();
            $table->timestamp('read_at')->nullable();

            $table->unique(['user_id', 'notice_id']);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //

        Schema::dropIfExists('user_notice');
    }
};
