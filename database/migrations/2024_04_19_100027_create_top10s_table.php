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
        Schema::create('top10s', function (Blueprint $table) {
            $table->id();
            $table->string('movieId');
            $table->string('originalTitleText');
            $table->string('isAdult');
            $table->string('isRatable');
            $table->string('imageUrl');
            $table->string('aggregateRating');
            $table->string('releaseYear');
            $table->string('titleType');
            $table->string('isSeries');
            $table->string('plotText');
            $table->string('country');
            $table->string('runtime');
            $table->string('genres');
            $table->string('trailer');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('top10s');
    }
};
