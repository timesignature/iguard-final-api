<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class AdminController extends Controller
{
    //


    public function create(Request $request){
        $this->validate($request,[
            'name'=>'required',
            'email'=>'required|unique:users|email',
            'password'=>'required|same:confirm|min:8',
        ]);

        $a=new Admin();
        $a->name=$request->name;
        $a->email=$request->email;
        $a->password=Hash::make($request->password);
        $a->api_token=Str::random(60);
        $a->save();
        return $a;

    }

    public function login(Request $request){
        $this->validate($request,[
            'email'=>'required|email|exists:admins',
            'password'=>'required|min:8'
        ]);


        if (Auth::guard('admin')->attempt([
            'email' => $request->email,
            'password' => $request->password,
        ])) {
            return response()->json([
                // 'token' => $token,
                'token'=>Auth::guest('admin')->user()->api_token
            ], 200);

        }else{
            return response()->json(['error' => 'Unauthorised'], 401);
        }
    }
}
