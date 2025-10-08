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
        Schema::create('episodes', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->foreignId('season_id')->constrained('seasons')->cascadeOnDelete();
            $table->integer('tmdb_id')->unique();
            $table->integer('episode_number')->default(1);
            $table->string('title', 255);
            $table->text('overview')->nullable();
            $table->date('air_date')->nullable();
            $table->string('still_path', 255)->nullable();
            $table->float('vote_average')->default(0);
            $table->integer('vote_count')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent()->useCurrentOnUpdate();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('episodes');
    }
};