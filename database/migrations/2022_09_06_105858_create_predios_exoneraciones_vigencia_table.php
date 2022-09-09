<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePrediosExoneracionesVigenciaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('predios_exoneraciones_vigencia', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_predio');
            $table->unsignedBigInteger('id_concepto_predio');
            $table->smallInteger('exoneracion_desde');
            $table->smallInteger('exoneracion_hasta');
            $table->string('escritura', 10);
            $table->string('matricula', 11);
            $table->string('certificado_libertad', 10);
            $table->boolean('estado')->default(1);
            $table->timestamps();

            $table->foreign('id_predio')->references('id')->on('predios');
            $table->foreign('id_concepto_predio')->references('id')->on('conceptos_predio');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('predios_exoneraciones_vigencia');
    }
}
