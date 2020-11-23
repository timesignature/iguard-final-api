<?php

namespace App\Http\Controllers;

use App\Mail\AuthMail;
use App\Models\Security;
use App\Models\User;
use Faker\Provider\DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class SecurityController extends Controller
{
    //


    public function create(Request $request){
        $this->validate($request,[
            'name'=>'required|unique:securities',
            'address'=>'required',
            'city'=>'required',
            'country'=>'required',
            'postal'=>'required',
            'state'=>'required',
            'mobile_phone'=>'required',
            'business_phone'=>'required',
            'email'=>'required|unique:securities|email',
            'password'=>'required|same:confirm|min:8',
        ]);

        $s=new Security();
        $s->name=$request->name;
        $s->address=$request->address;
        $s->city=$request->city;
        $s->country=$request->country;
        $s->postal=$request->postal;
        $s->state=$request->state;
        $s->last_date=now();
        $s->mobile_phone=$request->mobile_phone;
        $s->business_phone=$request->business_phone;
        $s->email=$request->email;
        $s->api_token=Str::random(60);
        $s->password=Hash::make($request->password);
        $s->save();

        return $s;


    }
    public function login(Request $request){
        $this->validate($request,[
            'email'=>'required|email|exists:securities',
            'password'=>'required|min:8'
        ]);


        if (Auth::guard('security')->attempt([
            'email' => $request->email,
            'password' => $request->password,
        ])) {
            return response()->json([
                'token'=>Security::where('email',$request->email)->first()->api_token,
                'id'=>Security::where('email',$request->email)->first()->id,
            ], 200);

        }else{
            return response()->json(['error' => 'Unauthorised'], 401);
        }
    }
    public function reset_password(Request $request){
        $this->validate($request,[
            'email'=>'required|email|exists:securities'
        ]);

        $token=Str::random(10);

        DB::table('password_resets')->insert([
            'email'=>$request->email,
            'token'=>$token
        ]);

        Mail::to($request->email)->send(new AuthMail($token));


        return true;

    }
    public function reset(Request $request){
        $this->validate($request,[
            'password'=>'required|same:confirm|min:8',
            'token'=>'required|min:10|exists:password_resets'
        ]);

        $p=DB::table('password_resets')->where('token',$request->token)->first();

        if(!$p){
            return response([
             'message'=>'invalid token'
            ],400);
        }


        $s=Security::where('email',$p->email)->first();
        $s->password=Hash::make($request->password);
        $s->update();
        return $s;



    }
    public function get(Request $request){
        $search=$request->search;
        return Security::with(['sites','gds','clients'])
            ->orderBy('id','desc')
            ->where('name','LIKE',"%$search%")
            ->get();
    }
    public function getOne($id){
        return Security::find($id);
    }
    public function update($id,Request $request){

        $this->validate($request,[
            'last_date'=>'required'
        ]);

        $s=Security::find($id);
        $s->last_date=$request->last_date;
        $s->active=$request->active;
        $s->update();
        return $s;

    }



    public function update_activation_based_on_subscription($id){

    }
}
