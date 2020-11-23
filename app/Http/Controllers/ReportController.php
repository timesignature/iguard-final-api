<?php

namespace App\Http\Controllers;

use App\Models\Report;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ReportController extends Controller
{
    //

    public function add(Request $request){
        $this->validate($request,[
            'details'=>'required'
        ]);

        $r=new Report();
        $r->details=$request->details;
        $r->image='http://192.168.43.125/app/'.$this->upload_base64_img($request);
        $r->site_id=$request->site_id;
        $r->shift_id=$request->shift_id;
        $r->gd_id=$request->user()->id;
        $r->security_id=$request->user()->security_id;
        $r->save();
        return $r;
    }


    public function upload_base64_img($val){
        $data = base64_decode($val->image);
        $name=Str::random(10).'-'.time().'.png';
        Storage::disk('local')->put($name, $data);
        return $name;
    }

    public function file_upload($request){

        if($request->hasFile('image')){
            $image=$request->file('image');
            return $image->store('reports');
        }
        return null;
    }


    public function get($id){
        return Report::where('shift_id',$id)->get();
    }




}
