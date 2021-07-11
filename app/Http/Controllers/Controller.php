<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    Public function success($data, $message){
        return \response()->json([
            'success' => $message,
            'data'  =>  $data,
        ],200);
    }
    Public function failed($message){
        return \response()->json([
            'success' => $message,
            'data'  =>  '',
        ],500);
    }
    Public function notFound($message){
        return \response()->json([
            'success' => $message,
            'data'  =>  '',
        ],404);
    }
}
