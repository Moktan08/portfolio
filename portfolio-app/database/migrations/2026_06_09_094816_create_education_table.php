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
        Schema::create('education', function (Blueprint $table) {
        $table->id();
        $table->string('degree');       // e.g., "Bachelors in Software Engineering"
        $table->string('institution');  // e.g., "Sichuan University"
        $table->string('location');     // e.g., "Sichuan, China"
        $table->string('duration');     // e.g., "Oct 2016 – July 2020"
        $table->text('key_modules');    // To hold the list of academic subjects
        $table->timestamps();
    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('education');
    }
};
