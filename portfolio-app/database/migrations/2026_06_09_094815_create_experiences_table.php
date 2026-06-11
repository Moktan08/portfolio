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
        Schema::create('experiences', function (Blueprint $table) {
        $table->id();
        $table->string('position');       // e.g., "Web Development Intern"
        $table->string('company');        // e.g., "SunCaper"
        $table->string('location');        // e.g., "Sichuan, China"
        $table->string('duration');       // e.g., "Apr 2020 – July 2020"
        $table->text('responsibilities'); // We can store bullet points here split by lines or JSON
        $table->integer('sort_order')->default(0); // To arrange them newest-to-oldest manually
        $table->timestamps();
    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('experiences');
    }
};
