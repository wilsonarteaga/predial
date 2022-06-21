<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePrediosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('predios', function (Blueprint $table) {
            $table->id();
            $table->string('codigo_predio', 40);
            $table->string('direccion', 512);
            $table->decimal('avaluo', $precision = 20, $scale = 2);
            $table->smallInteger('ultimo_anio_pago');
            $table->unsignedBigInteger('id_zona'); // RURAL, URBANO

            $table->char('tipo', 2);
            $table->char('sector', 2);
            $table->char('manzana', 4);
            $table->char('predio', 4);
            $table->char('mejora', 3);

            $table->decimal('area_metros', $precision = 12, $scale = 2);
            $table->decimal('area_construida', $precision = 12, $scale = 2);
            $table->decimal('area_hectareas', $precision = 12, $scale = 2);
            $table->decimal('tarifa_actual', $precision = 12, $scale = 2);

            $table->timestamps();

            $table->foreign('id_zona')->references('id')->on('zonas');

            $table->unique('codigo_predio');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('predios');
    }
}
