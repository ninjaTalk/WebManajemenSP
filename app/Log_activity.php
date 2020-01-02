<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Log_activity extends Model
{
    protected $table ='log_activities';
    protected $fillable = ['idPegawai', 'kodeTransaksi','description', 'debit', 'debt', 'saldoBefore'];
}
