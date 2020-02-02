<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Costumer;
use Illuminate\Database\Eloquent\SoftDeletes;

class Saving extends Model
{
    use  SoftDeletes;
    protected $fillable =['kodeTabungan', 'name', 'saldo', 'updated_at', 'created_at', 'deleted_at'];
    protected $dates = ['deleted_at'];
}
