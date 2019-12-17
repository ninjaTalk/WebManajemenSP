<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('kodeTransaksi', 50)->unique();
            $table->date('$tglInput');
            $table->string('$transactionType', 10);
            $table->integer('debit')->nullable();
            $table->integer('debt')->nullable();
            $table->string('kodeTabungan', 8);
            $table->string('ppNomor', 20);
            $table->integer('idNasabah')->nullable();
            $table->char('idPegawai')->nullable();
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
        Schema::dropIfExists('transactions');
    }
}
