<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHistorialCuentasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('historial_cuentas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('cuentas_por_cobrar_id')->constrained('cuentas_por_cobrar');
            $table->double('deposit');
            $table->string('type');
            $table->double('balance_at');
            $table->date('payment_date');
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
        Schema::dropIfExists('historial_cuentas');
    }
}
