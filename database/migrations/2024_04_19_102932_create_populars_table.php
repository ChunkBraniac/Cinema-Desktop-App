<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('populars', function (Blueprint $table) {
            $table->id();
            $table->string('movieId');
            $table->string('isAdult');
            $table->string('isRatable');
            $table->string('originalTitleText');
            $table->string('imageUrl')->nullable();
            $table->string('aggregateRating')->nullable();
            $table->string('releaseYear')->nullable();
            $table->string('titleType');
            $table->string('titleTypeText');
            $table->string('canHaveEpisodes');
            $table->string('isSeries');
            $table->string('genres')->nullable();
            $table->string('trailer')->nullable();
            $table->longText('plotText');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('populars');
    }
};
