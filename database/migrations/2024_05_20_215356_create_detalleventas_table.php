<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDetalleventasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('detalleventas', function (Blueprint $table) {
            $table->bigInteger('idDetalleVenta')->primaryKey()->autoIncrement()->unsigned();
            $table->biginteger('venta_id')->unsigned();
            $table->foreign('venta_id')->references('idVenta')->on('ventas');
            $table->biginteger('producto_id')->unsigned();
            $table->foreign('producto_id')->references('idProducto')->on('productos');
            $table->decimal('valor_v')->default('0');
            $table->biginteger('cantidad_v')->default('0');
            $table->decimal('neto_v')->default('0');
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
        Schema::dropIfExists('detalleventas');
    }
}
