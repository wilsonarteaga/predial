<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePrescripcionesPrediosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('prescripciones_predios', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_predio');
            $table->smallInteger('prescribe_hasta');
            $table->timestamps();

            $table->foreign('id_predio')->references('id')->on('predios');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('prescripciones_predios');
    }
}
