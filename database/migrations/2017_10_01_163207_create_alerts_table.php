<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAlertsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('alertas', function(Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            $table->boolean('read');
            $table->string('title');
            $table->string('conteudo');
            $table->string('url');
            $table->enum('type', ['success', 'info', 'warning', 'danger'])->default('info');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('alertas');
    }
}
