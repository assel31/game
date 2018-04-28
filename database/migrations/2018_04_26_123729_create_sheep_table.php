<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSheepTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sheep', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->boolean('is_dead')->default(0);
            $table->integer('sheepfold_id')->unsigned();
            $table->timestamps();

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
        Schema::dropIfExists('sheep');
    }
}
