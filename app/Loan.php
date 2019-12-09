<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;

class Loan extends Model
{
    use SoftDeletes;
    protected $fillable = ['ppNomor', 'tglPinjam', 'saldoPinjaman',
        'loanType', 'jaminan', 'name', 'noKtp', 'status', 'idPegawai',
        'bunga', 'pokokPinjaman', 'jmlAngsur'];
    protected $detes = ['deleted_at'];
}
