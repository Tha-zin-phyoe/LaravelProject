<?php

namespace App\Http\Controllers;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function register(Request $request){
        $validator = Validator::make($request->all(),[
            "name"=>'required|string',
            "email"=>'required|email|string',
            "password"=>'required|max:6'
        ]);
        if($validator->fails()){
            return response()->json([
                "error"=>$validator->errors(),
                "message"=>"Validation Error"
            ],400);
        }
         $user = User::create([
            "name"=>$request->name,
            "email"=>$request->email,
            "password"=>Hash::make($request->password)
         ]);
         $token = $user->createToken('token')->plainTextToken;
         return response()->json([
            'user'=>$user,
            'token'=>$token,
            'status'=>'User Created Successfully'
         ],201);
    }
    public function login(Request $request){
        $validator = Validator::make($request->all(),[
            "email"=>'required|email|string',
            "password"=>'required|max:6'
        ]);
        if($validator->fails()){
            return response()->json([
                "error"=>$validator->errors(),
                "message"=>"Validation Error"
            ],400);
        }
       if(!Auth::attempt($request->only(['email','password']))){
        return response()->json([
            "status"=>false,
            "message"=>'Validation Error!Please try to log in again',

        ],401);
       }
       $user = User::where('email',$request->email)->first();
       return response()->json([
        "status"=>true,
        "message"=>"Logged in Successfully",
        'token' => $user->createToken("token")->plainTextToken
       ],201);

    }

}
