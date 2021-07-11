<?php

namespace App\Http\Controllers;

use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserProfileController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
    }

    public function index(){
        try{
            $users = User::all();
            return $this->success($users,"All Users List");
        }catch(Exception $e){
            return $this->failed("Data not found");
        }
    }

    public function profile(){
        $user = User::where('id', Auth::user()->id)->get();
        if($user){
            return $this->success($user, 'Your Profile');
        }else{
            return $this->failed('You');
        }

    }
    public function profile_profile(Request $request, $id){
        $validator = Validator::make($request->all(),[
            'name' => 'required|string',
            'email' => 'required|email',
            'password' => 'required|string|min:6',
        ]);
        if($validator->fails()){
            return \response()->json([
                $validator->errors()
            ],400);
        }
        try{
            $user = User::find($id);
            $user->update([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
            ]);
            return $this->success($user, 'Your Profile Updated');
        }catch(Exception $e){
            return $this->failed($e->getMessage());
        }

    }

    public function destroy($id){
        $user =User::find($id);
        if($user){
            $user->delete();
            return $this->success($user, 'User Data Deleted!');
        }else{
            return $this->failed("data already deleted");
        }
    }
}
