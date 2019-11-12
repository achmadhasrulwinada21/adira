<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddmetaArtikelTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('artikel', function($table) {
             $table->string('meta_title')->nullable();
             $table->string('meta_description')->nullable();
            });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('artikel', function($table) {
            $table->dropColumn('meta_title');
            $table->dropColumn('meta_description');
           });
    }
}
