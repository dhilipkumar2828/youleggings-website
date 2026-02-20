<?php

namespace App\Http\Controllers\Admin;

use App\Models\Hotoffer;

use App\Models\ProductVariant;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;

use App\Http\Controllers\Controller;

use Illuminate\Support\Str;

use Illuminate\Support\Facades\Session;

use Auth;

class HotofferController extends Controller

{

   function __construct()

   {

        $this->middleware('permission:Hot Offer Create|Hot Offer View|Hot Offer Edit|Hot Offer Delete', ['only' => ['view','store']]);

        $this->middleware('permission:Hot Offer Create', ['only' => ['add','store']]);

        $this->middleware('permission:Hot Offer Edit', ['only' => ['edit','update','update','update_status']]);

        $this->middleware('permission:Hot Offer Delete', ['only' => ['delete']]);

        $this->userid=@Auth::user()->roles[0]->id;

        $this->username=@Auth::user()->roles[0]->name;

   }

    /**

     * Display a listing of the resource.

     *

     * @return \Illuminate\Http\Response

     */

    public function view()

    {

            $offers=Hotoffer::orderBy('id','desc')->get();

            $productimg=array();

            foreach($offers as $key=>$o){

                   $A_prodimg = explode(',', $o->photo);

                   array_push($productimg,$A_prodimg[0]);

               }

            return view('backend.hotoffer.view',compact('offers','productimg'));

    }

    public function add()

    {

            return view('backend.hotoffer.add');

    }

    public function edit($id)

    {

            $offer=Hotoffer::orderBy('id','desc')->where('id',$id)->first();

            return view('backend.hotoffer.edit',compact('offer'));

    }

    public function store(Request $request){

        $hot_offers=new Hotoffer;

        $hot_offers->title=$request->title;

        $hot_offers->photo=$request->photo;

        $hot_offers->description=$request->description;

        $hot_offers->link=$request->link;

        $hot_offers->save();

        Session::put('success','Hotoffer created successfully');

        return redirect('view_hotoffer');

    }

 public function delete(Request $request,$id){

    Hotoffer::where('id',$id)->delete();

    Session::put('success','Hotoffer deleted successfully');

    return redirect('view_hotoffer');

 }

 public function update_status(Request $request){

    Hotoffer::where('id',$request->id)->update(['status'=>$request->mode]);

 }

 public function update(Request $request,$id){

    Hotoffer::where('id',$id)->update(['title'=>$request->title,'link'=>$request->link,'photo'=>$request->photo,'description'=>$request->description]);

    Session::put('success','Hotoffer updated successfully');

    return redirect('view_hotoffer');

}

}
