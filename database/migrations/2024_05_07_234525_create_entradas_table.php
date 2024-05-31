<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEntradasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('entradas', function (Blueprint $table) {
            $table->bigInteger('idEntrada')->primaryKey()->autoIncrement()->unsigned();
            $table->biginteger('producto_id')->unsigned();
            $table->foreign('producto_id')->references('idProducto')->on('productos');
            $table->string('num_factura')->default('FC');
            $table->date('fecha_ent');
            $table->biginteger('cantidad_ent')->default('0');
            $table->decimal('valor_pd')->default('0');
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
        Schema::dropIfExists('entradas');
    }
}
