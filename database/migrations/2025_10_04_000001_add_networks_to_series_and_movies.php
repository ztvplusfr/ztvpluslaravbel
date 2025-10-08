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
        Schema::table('series', function (Blueprint $table) {
            $table->json('networks')->nullable()->after('age_rating');
        });
        
        Schema::table('movies', function (Blueprint $table) {
            $table->json('networks')->nullable()->after('age_rating');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('series', function (Blueprint $table) {
            $table->dropColumn('networks');
        });
        
        Schema::table('movies', function (Blueprint $table) {
            $table->dropColumn('networks');
        });
    }
};
