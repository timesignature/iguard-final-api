<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Site;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SiteController extends Controller
{
    public function add(Request $request){
        $this->validate($request,[
            'client'=>'required',
            'address'=>'required',
            'lat'=>'required|numeric',
            'long'=>'required|numeric',
        ]);

        $s=new Site();
        $s->client_id=$request->client;
        $s->security_id=$request->user()->id;
        $s->address=$request->address;
        $s->lat=$request->lat;
        $s->long=$request->long;
        $s->save();
        return $s;
    }


    public function getForGuard(Request $request){
        return Site::with(['client'])
            ->where('security_id',$request->user()->security_id)
            ->get();
    }


    public function get(Request $request){
        $search=$request->search;
        return Site::with(['client'])
            ->where('security_id',$request->user()->id)
            ->where('address','LIKE',"%$search%")
            ->get();
    }


    public function grouped(){
        return Client::with(['sites'])->get();
    }

    public function getOne($id){
        return Site::with(['client'])->where('id',$id)->first();
    }
}
