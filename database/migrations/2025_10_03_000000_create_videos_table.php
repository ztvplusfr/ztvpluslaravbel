<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('videos', function (Blueprint $table) {
            $table->id();
            $table->string('embed_link'); // Lien embed de la vidéo
            $table->string('language'); // Langue de la vidéo
            $table->string('quality'); // Qualité de la vidéo (ex: 1080p, 720p)
            $table->string('server_name'); // Nom du serveur (ex: YouTube, Vimeo)
            $table->string('subtitle')->nullable(); // Sous-titre (optionnel)
            $table->boolean('is_active')->default(true); // Statut actif ou non
            $table->unsignedBigInteger('movie_id')->nullable(); // Clé étrangère pour les films
            $table->unsignedBigInteger('episode_id')->nullable(); // Clé étrangère pour les épisodes
            $table->timestamps();

            $table->foreign('movie_id')->references('id')->on('movies')->onDelete('cascade');
            $table->foreign('episode_id')->references('id')->on('episodes')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('videos');
    }
};