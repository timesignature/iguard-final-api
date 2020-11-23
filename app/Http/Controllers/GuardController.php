<?php

namespace App\Http\Controllers;

use App\Models\Guard;
use App\Models\Security;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class GuardController extends Controller
{
    public function add(Request $request){

        $this->validate($request,[
            'name'=>'required',
            'address'=>'required',
            'phone'=>'required',
            'gender'=>'required',
            'national_id'=>'required',
            'pin'=>'required|min:4',
        ]);

        $c=new Guard();
        $c->name=$request->name;
        $c->address=$request->address;
        $c->phone=$request->phone;
        $c->gender=$request->gender;
        $c->national_id=$request->national_id;
        $c->email=$request->national_id;
        $c->api_token=Str::random(60);
        $c->password=Hash::make($request->pin);
        $c->kept_pin=$request->pin;
        $c->security_id=$request->user()->id;
        $c->save();
        return $c;
    }


    public function get(Request $request){
        $get_guard=$request->guard_search_request;
        return Guard::where('name','LIKE',"%$get_guard%")
            ->get();
    }


    public function login(Request $request){
        $this->validate($request,[
            'email'=>'required|exists:guards',
            'password'=>'required|min:4'
        ]);


        if (Auth::guard('guard')->attempt([
            'email' => $request->email,
            'password' => $request->password,
        ])) {
            return response()->json([
                // 'token' => $token,
                'token'=>Guard::where('national_id',$request->email)->first()->api_token
            ], 200);

        }else{
            return response()->json(['error' => 'Unauthorised'], 401);
        }
    }
}
