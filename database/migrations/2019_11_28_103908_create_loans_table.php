<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLoansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('loans', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('ppNomor', 20)->unique();
            $table->date('tglPinjam');
            $table->integer('saldoPinjaman');
            $table->string('loanType', 10);
            $table->string('jaminan', 50);
            $table->string('name', 50);
            $table->string('noKtp', 16);
            $table->string('status', 10);
            $table->string('idPegawai', 5);
            $table->double('bunga');
            $table->integer( 'pokokPinjaman');
            $table->integer('jmlAngsur');
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
        Schema::dropIfExists('loans');
    }
}
