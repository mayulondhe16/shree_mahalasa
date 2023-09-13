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
        Schema::table('main_category', function (Blueprint $table) {
            $table->dropColumn('description');
           
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('main_category', function (Blueprint $table) {
            if (!Schema::hasColumn('main_category', 'description')) {
                $table->string('description');
            }
          
            // $table->dropColumn('link'); // Remove the 'link' column
        });
    }
};
