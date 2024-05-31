<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CreateVentasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ventas', function (Blueprint $table) {
            $table->bigInteger('idVenta')->primaryKey()->autoIncrement()->unsigned();
            $table->datetime('fecha_v')->default('0')->default(DB::raw('CURRENT_TIMESTAMP'))->nullable();
            $table->biginteger('cliente_id')->unsigned();
            $table->foreign('cliente_id')->references('idCliente')->on('clientes');
            $table->decimal('total_fact')->default('0');
            $table->biginteger('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users');
            $table->enum('estado_v', ['ABIERTA', 'CERRADA'])->default('ABIERTA');
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
        Schema::dropIfExists('ventas');
    }
}
