<?php

namespace App\Http\Controllers\Admin;

use App\Models\Clientfeedback;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;

use App\Http\Controllers\Controller;

use Illuminate\Support\Str;

use Illuminate\Support\Facades\Session;

use Auth;

class FeedbackController extends Controller

{

      function __construct()

      {

         $this->middleware('permission:Client Feedback View|Client Feedback Edit|Client Feedback Delete', ['only' => ['view','store']]);

         $this->middleware('permission:Client Feedback Edit', ['only' => ['edit','update']]);

         $this->middleware('permission:Client Feedback Delete', ['only' => ['delete']]);

         $this->userid=@Auth::user()->id;

         $this->username=@Auth::user()->name;

      }

    /**

     * Display a listing of the resource.

     *

     * @return \Illuminate\Http\Response

     */

    public function view()

    {

            $feedbacks=Clientfeedback::orderBy('id','desc')->get();

            return view('backend.feedback.view',compact('feedbacks'));

    }

 public function delete(Request $request,$id){

    Clientfeedback::where('id',$id)->delete();

    Session::put('success','Feedback deleted successfully');

    return redirect('view_feedback');

 }

 public function update(Request $request){

    Clientfeedback::where('id',$request->id)->update(['status'=>$request->mode]);

 }

}
