<?php

namespace App\Http\Controllers;

use App\Models\Patrol;
use Illuminate\Http\Request;

class PatrolController extends Controller
{
    //


    public function add(Request $request){
        $this->validate($request,[
            'details'=>'required',
            'scanned'=>'required',
        ]);

        $p=new Patrol();
        $p->gd_id=$request->user()->id;
        $p->security_id=$request->user()->security_id;
        $p->site_id=$request->site_id;
        $p->shift_id=$request->shift_id;
        $p->scanned=$request->scanned;
        $p->details=$request->details;
        $p->save();
        return $p;
    }

    public function get($id){
      return Patrol::where('shift_id',$id)->get();
    }
}
