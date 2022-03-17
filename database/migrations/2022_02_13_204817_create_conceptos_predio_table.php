<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateConceptosPredioTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('conceptos_predio', function (Blueprint $table) {
            $table->id();
            $table->smallInteger('anio');
            $table->smallInteger('mes_amnistia');
            $table->integer('codigo');
            $table->string('nombre', 128);
            $table->string('formula', 1024);
            $table->tinyInteger('aplica_interes');
            $table->tinyInteger('prioridad');
            $table->decimal('minimo_urbano', $precision = 12, $scale = 2);
            $table->decimal('minimo_rural', $precision = 12, $scale = 2);
            $table->decimal('capital', $precision = 12, $scale = 2);
            $table->decimal('interes', $precision = 12, $scale = 2)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('conceptos_predio');
    }
}
