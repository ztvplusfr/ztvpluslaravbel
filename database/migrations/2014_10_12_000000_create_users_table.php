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
        Schema::create('users', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name', 100);
            $table->string('email', 150)->unique();
            $table->string('password', 255);
            $table->string('avatar', 255)->nullable();
            $table->string('language', 10)->default('fr');
            $table->string('country', 5)->default('RE');
            $table->integer('max_streams')->default(1);
            $table->timestamp('last_login')->nullable()->default(null);
            $table->string('remember_token', 100)->nullable()->default(null);
            $table->boolean('is_active')->default(true);
            $table->json('preferences')->nullable();
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent()->useCurrentOnUpdate();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
