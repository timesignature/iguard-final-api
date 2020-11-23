<?php

namespace App\Http\Controllers;

use App\Models\Shift;
use Illuminate\Http\Request;

class ShiftController extends Controller
{
    //


    public function add(Request $request){
        $this->validate($request,[
            'site_id'=>'required',
            'lat'=>'required',
            'lng'=>'required',
        ]);


        $s=new Shift();
        $s->site_id=$request->site_id;
        $s->lat=$request->lat;
        $s->lng=$request->lng;
        $s->gd_id=$request->user()->id;
        $s->security_id=$request->user()->security_id;
        $s->save();
        return $s;

    }


    public function get(Request $request){
        $security= $request->user()->id;
        return Shift::with(['gd','site','security'])
            ->where('security_id',$security)
            ->orderBy('created_at','desc')
            ->get();
    }



    public function getBySec(Request $request){
        $security_id=$request->user()->id;
        return Shift::where('security_id',$security_id)->get();
    }

    public function getById(Request $request,$id){
        $security= $request->user()->id;
        return Shift::with(['gd','site'])
            ->where('id',$id)
            ->where('security_id',$security)
            ->first();
    }

    public function getLast(Request $request){
        return Shift::where('gd_id',$request->user()->id)
            ->orderBy('created_at','desc')
            ->get();
    }


    public function end($id){
        $shift=Shift::where('id',$id)->first();
        $shift->status=false;
        $shift->update();
        return $shift;
    }
}
