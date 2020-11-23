<?php

namespace App\Http\Controllers;

use App\Models\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class ClientController extends Controller
{
    //
    public function add(Request $request){
        if($request->type=='individual'){
            $this->validate($request,[
                'name'=>'required',
                'type'=>'required',
                'gender'=>'required',
                'address'=>'required',
                'phone'=>'required',
                'national_id'=>'required',
                'email'=>'required|email|unique:clients',
                'password'=>'required|min:8',
            ]);
        }else{
            $this->validate($request,[
                'name'=>'required',
                'type'=>'required',
                'address'=>'required',
                'phone'=>'required',
                'email'=>'required|email|unique:clients',
                'password'=>'required|min:8',
            ]);
        }

        $c=new Client();
        $c->name=$request->name;
        $c->address=$request->address;
        $c->phone=$request->phone;
        $c->gender=$request->gender;
        $c->type=$request->type;
        $c->national_id=$request->national_id;
        $c->email=$request->email;
        $c->api_token=Str::random(60);
        $c->password=Hash::make($request->password);
        $c->security_id=$request->user()->id;
        $c->save();

        return $c;

    }

    public function get(Request $request){
        $search=$request->search;
        return Client::where('security_id',$request->user()->id)
            ->where('name','LIKE',"%$search%")
            ->get();
    }


    public function login(Request $request){
        $this->validate($request,[
            'email'=>'required|email|exists:clients'
        ]);
    }
}
