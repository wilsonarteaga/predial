<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAniosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('anios', function (Blueprint $table) {
            $table->id();
            $table->smallInteger('anio');
            $table->unsignedBigInteger('id_estado');
            $table->smallInteger('meses_amnistia');
            $table->timestamps();

            $table->foreign('id_estado')->references('id')->on('estados_anio');

            $table->unique('anio');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('anios');
    }
}
