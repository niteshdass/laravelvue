<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\User;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
class UserController extends Controller
{
    public function login(Request $request){
        
        $credentials = $request->only('email','password');

        if(Auth::attempt($credentials)){
            $token = Str::random(80);
            Auth::user()->api_token = $token;
            Auth::user()->save();
            return response()->json(['token'=>$token],200);
        }
            return response()->json(['status'=>'Email Or Password IS Incorrect'],403);

       } 
       
       public function user(){
        
        

        
             return response()->json(['users'=>User::all()],200);

       } 
}
