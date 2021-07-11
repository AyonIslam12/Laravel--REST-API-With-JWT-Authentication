<?php

namespace App\Http\Controllers;

use App\Models\User;
use Exception;
use GrahamCampbell\ResultType\Success;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login','register']]);
    }


    public function register(Request $request){
        $validator = Validator::make($request->all(),[
            'name' => 'required|string',
            'email' => 'required|email|unique:users',
            'password' => 'required|string|min:6',
        ]);
        if($validator->fails()){
            return \response()->json([
                $validator->errors()
            ],400);
        }
        try{
           $user =  User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' =>Hash::make($request->password),
            ]);
            return $this->success($user,'User Registration Successful');
        }catch(Exception $e){
            return $this->failed('Not Register!');
        }

    }

    public function login(Request $request){
        $validator = Validator::make($request->all(),[

            'email' => 'required|email',
            'password' => 'required|string|min:6',
        ]);
        if($validator->fails()){
            return \response()->json([
                $validator->errors()
            ],400);
        }
        $credentials = $request->only('email', 'password');
        if ($token = Auth::attempt($credentials)) {
            return $this->respondWithToken($token);
        }
        return response()->json(['error' => 'Credentials does not match'], 401);
    }

    public function refresh()
    {
        return $this->respondWithToken($this->guard()->refresh());
    }

    public function logout()
    {
        Auth::logout();

        return response()->json(['message' => 'Successfully logged out']);
    }

    /**
     * Get the token array structure.
     *
     * @param  string $token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => $this->guard()->factory()->getTTL() * 60
        ]);
    }

    /**
     * Get the guard to be used during authentication.
     *
     * @return \Illuminate\Contracts\Auth\Guard
     */
    public function guard()
    {
        return Auth::guard();
    }


}
