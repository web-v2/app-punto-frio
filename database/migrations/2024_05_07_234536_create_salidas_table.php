<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSalidasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('salidas', function (Blueprint $table) {
            $table->bigInteger('idSalida')->primaryKey()->autoIncrement()->unsigned();
            $table->biginteger('producto_id')->unsigned();
            $table->foreign('producto_id')->references('idProducto')->on('productos');
            $table->string('motivo_sal');
            $table->date('fecha_sal');
            $table->biginteger('cantidad_sal')->default('0');
            $table->biginteger('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users');
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
        Schema::dropIfExists('salidas');
    }
}
