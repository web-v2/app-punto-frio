<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProveedorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('proveedors', function (Blueprint $table) {
            $table->bigInteger('idProveedor')->primaryKey()->autoIncrement()->unsigned();
            $table->bigInteger('dni_pv')->unsigned();
            $table->String('nombre_pv', 100);
            $table->String('contacto_pv', 60)->default('Company')->nullable();
            $table->String('telefono_pv', 15)->default('0')->nullable();
            $table->String('direccion_pv', 80)->default('Cll')->nullable();
            $table->biginteger('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users');
            $table->enum('estado_pv', ['ACTIVO', 'INACTIVO'])->default('ACTIVO');
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
        Schema::dropIfExists('proveedors');
    }
}
