<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('productos', function (Blueprint $table) {
            $table->bigInteger('idProducto')->primaryKey()->autoIncrement()->unsigned();
            $table->text('descripcion_pd')->nullable();
            $table->biginteger('proveedor_id')->unsigned();
            $table->foreign('proveedor_id')->references('idProveedor')->on('proveedors');
            $table->decimal('valor_pd')->default('0');
            $table->biginteger('existencia_pd')->default('0');
            $table->biginteger('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users');
            $table->enum('estado_pd', ['ACTIVO', 'INACTIVO'])->default('ACTIVO');
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
        Schema::dropIfExists('productos');
    }
}
