<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Costumer;

class Saving extends Model
{
    protected $fillable =['kodeTabungan', 'name'];
    public function customer(){
        return $this->belongsTo(Customer::class);
    }
}
