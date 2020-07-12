<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use App\Http\Controllers\API\BaseController as BaseController;
use App\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;


class RegisterController extends BaseController
{

    use AuthenticatesUsers;

    /**
        Register Api
     */

    public function register(Request $request){
        $validator = Validator::make($request->all(),[
           'name' => 'required',
           'email' => 'required|email',
           'password' => 'required',
           'c_password' => 'required|same:password',
        ]);

        if ($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());
        }

        $input = $request->all();
        $input['password'] = bcrypt($input['password']);
        $user = User::create($input);
        $success['token'] = $user->createToken('MyApp')->accessToken;
        $success['name'] = $user->name;
        return $success->json($success, 200);
      //  return $this->sendResponse($success, 'User Register successfully');
    }

    /**
        Login Api
     */

    public function login(Request $request){
        //Auth::guard('admin')->attempt(['idPegawai' =>$request->input('idPegawai'
        if (Auth::guard('api')->attempt(['email'=>$request->email, 'password' =>$request->password])){
            $user = Auth::guard('api')->user();
            $success['token'] = $user->createToken('MyApp')->accessToken;
            $success['name'] = $user->name;

            return $this->sendResponse($success, 'User Login Successfully');

        }else{
            return $this->sendError('Unauthenticated.', ['error'=>'Unauthorised']);
        }
    }
}
