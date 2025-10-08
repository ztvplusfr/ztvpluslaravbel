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
        Schema::table('movies', function (Blueprint $table) {
            $table->unsignedBigInteger('network_id')->nullable()->after('age_rating');
            $table->foreign('network_id')->references('id')->on('networks')->onDelete('set null');
        });
        if (Schema::hasColumn('movies', 'networks')) {
            Schema::table('movies', function (Blueprint $table) {
                $table->dropColumn('networks');
            });
        }

        Schema::table('series', function (Blueprint $table) {
            $table->unsignedBigInteger('network_id')->nullable()->after('age_rating');
            $table->foreign('network_id')->references('id')->on('networks')->onDelete('set null');
        });
        if (Schema::hasColumn('series', 'networks')) {
            Schema::table('series', function (Blueprint $table) {
                $table->dropColumn('networks');
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('movies', function (Blueprint $table) {
            $table->json('networks')->nullable()->after('age_rating');
            $table->dropForeign(['network_id']);
            $table->dropColumn('network_id');
        });

        Schema::table('series', function (Blueprint $table) {
            $table->json('networks')->nullable()->after('age_rating');
            $table->dropForeign(['network_id']);
            $table->dropColumn('network_id');
        });
    }
};