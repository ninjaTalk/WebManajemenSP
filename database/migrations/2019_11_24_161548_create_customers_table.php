<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCustomersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('customers', function (Blueprint $table) {
            $table->integer('idNasbah')->primary();
            $table->string('name', 100);
            $table->string('noKtp', 16)->unique();
            $table->string('gender', 10);
            $table->string('alamat', 100);
            $table->string('password', 8);
            $table->string('qrcode', 8);
            $table->string('idPegawai', 5);
            $table->char('kodeCollector', 1);
            $table->string('ppNomor', 20);
            $table->string('kodeTabungan', 8);
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
        Schema::dropIfExists('customers');
    }
}
