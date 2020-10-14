<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCuentasPorCobrarTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cuentas_por_cobrar', function (Blueprint $table) {
            $table->id();
            $table->string('code')->unique();
            $table->foreignId('invoice_id')->constrained();
            $table->foreignId('client_id')->constrained();
            $table->double('total_amount');
            $table->double('actual_balance')->default(0);
            $table->integer('fee')->nullable();
            $table->foreignId('payment_interval_id')->constrained('payment_date_intervals');
            $table->date('start_date');
            $table->date('finish_date')->nullable();
            $table->string('state')->default('pendiente');
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
        Schema::dropIfExists('cuentas_por_cobrar');
    }
}
