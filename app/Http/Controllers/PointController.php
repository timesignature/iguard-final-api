<?php

namespace App\Http\Controllers;

use App\Models\Point;
use Illuminate\Http\Request;

class PointController extends Controller
{
    //

    public function add(Request $request){
        $this->validate($request,[
            'details'=>'required'
        ]);


        $p=new Point();
        $p->shift_id=$request->shift_id;
        $p->details=$request->details;
        $p->scanned=1;
        $p->site_id=$request->site_id;
        $p->guard_id=$request->user()->id;
        $p->security_id=$request->user()->security_id;
        $p->save();
        return $p;
    }


    public function get(){
        return Point::all();
    }
}
