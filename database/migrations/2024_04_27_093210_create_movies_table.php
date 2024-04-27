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
        Schema::create('movies', function (Blueprint $table) {
            $table->id();
            $table->string('movieId');
            $table->string('isAdult');
            $table->string('isRatable');
            $table->string('originalTitleText');
            $table->string('imageUrl');
            $table->string('aggregateRating');
            $table->string('releaseYear');
            $table->string('titleType');
            $table->string('titleTypeText');
            $table->string('isSeries');
            $table->string('country');
            $table->string('runtime');
            $table->string('genres');
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
        Schema::dropIfExists('movies');
    }
};
