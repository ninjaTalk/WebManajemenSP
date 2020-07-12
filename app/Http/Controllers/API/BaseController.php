<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class BaseController extends Controller
{

    /**
        success response method
     */
    public function sendResponse($result, $message){
        $response = [
          'success' => true,
          'data'    => $result,
          'message' => $message,
        ];

        return $response()->json($response, 200);
    }

    /**
        failed / error response method
     */
    public function sendError($error, $errorMessages = [], $code = 404){
        $response = [
          'success' => false,
          'message' => $error
        ];

        if (!empty($errorMessages)){
            $response['data'] = $errorMessages;
        }

        return $response()->json($response, $code);
    }


}
