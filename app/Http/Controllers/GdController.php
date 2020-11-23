<?php

namespace App\Http\Controllers;

use App\Models\Gd;
use App\Models\Security;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class GdController extends Controller
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

        $c=new Gd();
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
        return Gd::where('security_id',$request->user()->id)
            ->where('name','LIKE',"%$get_guard%")
            ->get();
    }


    public function login(Request $request){
        $this->validate($request,[
            'email'=>'required|exists:gds',
            'password'=>'required|min:4'
        ]);


        if (Auth::guard('gd')->attempt([
            'email' => $request->email,
            'password' => $request->password,
        ])) {
            return response()->json([
                // 'token' => $token,
                'id'=>Gd::where('national_id',$request->email)->first()->id,
                'token'=>Gd::where('national_id',$request->email)->first()->api_token,
                'name'=>Gd::where('national_id',$request->email)->first()->name,
                'security'=>Gd::where('national_id',$request->email)->first()->security_id
            ], 200);

        }else{
            return response()->json(['error' => 'Unauthorised'], 401);
        }
    }
}
