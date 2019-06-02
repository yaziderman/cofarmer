<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProcessesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('processes', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('tractor_id')->unsigned();
            $table->integer('field_id')->unsigned();
            $table->integer('area')->unsigned()->default(0);
            $table->date('planned_date');
            $table->tinyInteger('approved')->default(0);
            $table->timestamps();
            $table->foreign('field_id')
            ->references('id')
            ->on('fields')
            ->onDelete('restrict');
            $table->foreign('tractor_id')
            ->references('id')
            ->on('tractors')
            ->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('processes');
    }
}
