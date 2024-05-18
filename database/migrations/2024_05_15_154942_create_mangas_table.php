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
        Schema::create('mangas', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('author_id');
            $table->unsignedBigInteger('genre_id');
            $table->string('title')->nullable(false);
            $table->string('description')->nullable(false);
            $table->date('release_date')->nullable(false);
            $table->string('image_path')->nullable(false);
            $table->boolean('is_deleted')->nullable(false)->default(false);
            $table->foreign('author_id')->references('id')->on('authors');
            $table->foreign('genre_id')->references('id')->on('genres');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mangas');
    }
};
