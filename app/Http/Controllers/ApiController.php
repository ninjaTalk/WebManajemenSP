<?php

namespace App\Http\Controllers;

use App\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;


class ApiController extends Controller
{
    public function getNasabah(){
        $data = Customer::all();
        return Response::json($data, 200);
    }
}
