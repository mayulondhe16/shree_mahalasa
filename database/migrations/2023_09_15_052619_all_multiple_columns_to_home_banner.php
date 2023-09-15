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
        Schema::table('home_banner', function (Blueprint $table) {
            $table->string('background_color_left');
            $table->string('background_color_right');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('home_banner', function (Blueprint $table) {
            $table->dropColumn('background_color_left');
            $table->dropColumn('background_color_right');

        });
    }
};
