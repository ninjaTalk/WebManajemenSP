<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    protected $fillable = ['id',
        'kodeTransaksi',
        'transactionType',
        'description',
        'idPegawai',
        'idNasabah',
        'debit',
        'debt',
        'bunga',
        'jml',
        'tglInput',
        'kodeTabungan',
        'ppNomor',
        'sisaSaldo',
    ];
}
