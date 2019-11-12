<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateArtikelTagTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('artikel_tag', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('id_artikel');
            $table->foreign('id_artikel')
            ->references('id')->on('artikel')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->unsignedBigInteger('id_tag');
            $table->foreign('id_tag')
            ->references('id')->on('tag')
                ->onDelete('cascade')
                ->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('artikel_tag');
    }
}
