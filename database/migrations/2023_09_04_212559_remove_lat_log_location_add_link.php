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
        Schema::table('location', function (Blueprint $table) {
            $table->dropColumn('lat');
            $table->dropColumn('long');
            $table->string('link'); // Add a new 'link' column
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('location', function (Blueprint $table) {
            if (!Schema::hasColumn('location', 'lat')) {
                $table->string('lat');
            }
            if (!Schema::hasColumn('location', 'long')) {
                $table->string('long');
            }
            // $table->dropColumn('link'); // Remove the 'link' column
        });
    }
};
