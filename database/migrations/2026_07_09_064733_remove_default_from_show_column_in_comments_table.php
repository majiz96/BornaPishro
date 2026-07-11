<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('comments', function (Blueprint $table) {
            //remove default value (0) from show column
            DB::statement('ALTER table `comments` MODIFY COLUMN `show` TINYINT(1) NULL');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('comments', function (Blueprint $table) {
            //describe previous conditions
            DB::statement('ALTER TABLE `comments` MODIFY COLUMN `show` INT(11) NOT NULL DEFAULT 0');
        });
    }
};
