<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class AuthController extends Controller
{
    //

    public function add(Request $request){
        $this->validate($request,[
            'name'=>'required',
            'email'=>'required|email|unique:users',
            'password'=>'required|min:8',
        ]);

        $u=new User();

        $u->name=$request->name;
        $u->email=$request->email;
        $u->api_token=Str::random(60);
        $u->password=Hash::make($request->password);
        $u->save();
        return $u;
    }


    public function login(Request $request){

        $this->validate($request,[
            'email'=>'required|email|exists:users',
            'password'=>'required|min:8',
        ]);


        if (Auth::attempt([
            'email' => $request->email,
            'password' => $request->password,
        ])) {
            return response()->json([
                // 'token' => $token,
                'token'=>User::where('email',$request->email)->first()->api_token,
                'id'=>User::where('email',$request->email)->first()->id,
            ], 200);

        }else{
            return response()->json(['error' => 'Unauthorised'], 401);
        }

    }
}
