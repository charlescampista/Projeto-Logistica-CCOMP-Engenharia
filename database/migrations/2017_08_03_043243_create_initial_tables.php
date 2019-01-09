<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInitialTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tipo_veiculo', function (Blueprint $table) {
            $table->increments('id');
            $table->string('tipo', 20);
            $table->integer('carga', false, true);
            $table->timestamps();
        });

        Schema::create('veiculos', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('tipo_id');
            $table->string('placa', 7);
            $table->timestamps();

            $table->foreign('tipo_id')
                ->references('id')
                ->on('tipo_veiculo')
                ->onDelete('cascade');
        });

        Schema::create('notas', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('veiculo_id');
            $table->string('codigo', 50);
            $table->boolean('aberto')->default(1);

            $table->dateTime('aviso_chegada')->nullable();
            $table->dateTime('abertura_portao')->nullable();
            $table->dateTime('descarga_inicio')->nullable();
            $table->dateTime('descarga_termino')->nullable();
            $table->dateTime('conferencia_nf_inicio')->nullable();
            $table->dateTime('conferencia_nf_termino')->nullable();
            $table->dateTime('aviso_saida')->nullable();
            $table->integer('box')->nullable();

            $table->timestamps();

            $table->foreign('veiculo_id')
                ->references('id')
                ->on('veiculos')
                ->onDelete('cascade');

            $table->unique('codigo');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('veiculos', function(Blueprint $table)
        {
            $table->dropForeign(['tipo_id']);
        });
        Schema::table('notas', function(Blueprint $table)
        {
            $table->dropForeign(['veiculo_id']);
        });
        Schema::dropIfExists('tipo_veiculo');
        Schema::dropIfExists('veiculos');
        Schema::dropIfExists('notas');
    }
}
