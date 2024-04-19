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
        Schema::create('upcomings', function (Blueprint $table) {
            $table->id();
            $table->string('movieId');
            $table->string('titleText');
            $table->string('titleType');
            $table->string('imageModel');
            $table->longText('caption');
            $table->string('releaseDate');
            $table->string('genres');
            $table->string('principalCredits');
            $table->string('releaseYear');
            $table->string('trailer');
            $table->longText('plotText');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('upcomings');
    }
};
