<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;

use App\Models\Subscribe;

use Illuminate\Http\Request;

use Auth;

use App\Jobs\SendSubscriberEmailJob;

use App\Providers\RouteServiceProvider;

use Illuminate\Foundation\Auth\AuthenticatesUsers;

use DB;

use Session;

use Illuminate\Support\Facades\Hash;

class SubscriberController extends Controller

{

      use AuthenticatesUsers {

        logout as performLogout;

    }

     public function subscribers(Request $request){

        if(Auth::user()){

                        $subscribers=Subscribe::get();

            return view('backend.subscribers.subscribe',compact('subscribers'));

        }else{

            $this->performLogout($request);

            return redirect()->route('admin');

        }

    }

    public function subscribe_send(Request $request)

    {

     $subscribe=new Subscribe;

     $subscribe->email=$request->email;

     $subscribe->save();

   $resval['success']=true;

   return response()->json(['resval'=>$resval]);

    }

    public function send_email(Request $request){

        $get_email=Subscribe::get();

        $details['email'] = 'kvraghul2018@gmail.com';

        dispatch(new \App\Jobs\SendSubscriberEmailJob($details));

        Session::put('success','Mail send Successfully');

        return redirect()->back();

    }

}
