<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateHistoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('histories', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('sheep_id')->unsigned();
            $table->integer('sheepfold_id')->unsigned();
            $table->integer('day')->unsigned();
            $table->string('action');

            $table->timestamps();

            $table->foreign('sheep_id')
                ->references('id')->on('sheep')
                ->onDelete('cascade');
            $table->foreign('sheepfold_id')
                ->references('id')->on('sheepfolds');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('histories');
    }
}
