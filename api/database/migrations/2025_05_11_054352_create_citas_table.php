<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCitasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('citas', function (Blueprint $table) {
            $table->id();

            $table->foreignId('paciente_id')
                ->constrained('users')
                ->onDelete('cascade');

            $table->foreignId('medico_id')
                ->constrained('users')
                ->onDelete('cascade');

            $table->foreignId('estado_id')
                ->constrained('estados')
                ->onDelete('restrict');

            $table->date('fecha');
            $table->time('hora');

            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('citas');
    }
}
