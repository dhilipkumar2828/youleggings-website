<?php

namespace App\Http\Controllers;

use Illuminate\Support\Str;

use App\Models\Blog;

use App\Models\Deals;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Session;

use App\Providers\RouteServiceProvider;

use Illuminate\Foundation\Auth\AuthenticatesUsers;

use Auth;

use DateTime;

use DB;

class DealsController extends Controller

{

    use AuthenticatesUsers {

        logout as performLogout;

    }

      function __construct()

    {

        //  $this->middleware('permission:Deals List|Deals Create|Deals Edit|Deals Delete', ['only' => ['index','store','deals']]);

        //  $this->middleware('permission:Deals Create', ['only' => ['create','store']]);

        //  $this->middleware('permission:Deals Edit', ['only' => ['edit','events_update','update']]);

        //  $this->middleware('permission:Deals Delete', ['only' => ['destroy']]);

         $this->userid=@Auth::user()->roles[0]->id;

         $this->username=@Auth::user()->roles[0]->name;

    }

    /**

     * Display a listing of the resource.

     *

     * @return \Illuminate\Http\Response

     */

      public function index(Request $request)

    {

        if(Auth::user()){

       $current_user=Auth::user()->name;

        }

       if(isset($current_user)){

        $deals=Deals::where('created_by',$current_user)->orderBy('id','DESC')->get();

        return view('backend.deals_of_day.views',compact('deals'));

        }else{

            $this->performLogout($request);

            return redirect()->route('admin');

        }

    }

    public function create()

    {

       $current_user=Auth::user()->name;

        $products=DB::table('products')->where('status','active')->get();

         $deals=Deals::where('created_by',$current_user)->orderBy('id','DESC')->get();

        return view('backend.deals_of_day.create',compact('deals','products'));

    }

    public function store(Request $request)

    {

        $this->validate($request,[

            'photo'=>'string|nullable',

            'sale_price'=>'nullable|numeric',

            'product_name'=>'string',

        ]);

       $current_user=Auth::user()->name;

     $deals_save =new Deals;

     $deals_save->description=$request->description;

     $deals_save->days=$request->days;

     $deals_save->photo=$request->photo;

     $deals_save->sale_price=$request->sale_price;

     $deals_save->product_name=$request->product_name;

     $deals_save->created_by=$current_user;

     $deals_save->save();

     if($deals_save){

     Session::put('success','Successfully created Blog');

     return redirect()->route('deals.index');

     }else{

        return back()->with('error','something went wrong!');

     }

    }

   public function deals_status(Request $request){

    if($request->mode=='true'){

        DB::table('deals_of_day')->where('id',$request->id)->update(['status'=>'active']);

    }

    else{

        DB::table('deals_of_day')->where('id',$request->id)->update(['status'=>'inactive']);

    }

    return response()->json(['msg'=>'Successfully update status','status'=>true]);

    }

    public function edit(Request $request,$id){

        $products=DB::table('products')->where('status','active')->get();

     $deals=DB::table('deals_of_day')->where('id',$id)->first();

        return view('backend.deals_of_day.edit',compact('deals','products'));

        }

        public function update(Request $request,$id){

            $deals=DB::table('deals_of_day')->where('id',$id)->update(['product_name'=>$request->product_name,'photo'=>$request->photo,'sale_price'=>$request->sale_price]);

            if($deals){

            Session::put('success','Successfully Updated ');

            return redirect()->route('deals.index');

            }

               }

               public function show(Request $request){

                $deals=DB::table('deals_of_day')->orderBy('id','desc')->first();

                return view('backend.deals_of_day.event_details',compact('deals'));

                   }

                   public function destroy(Request $request,$id){

                    $deals=DB::table('deals_of_day')->where('id',$id)->delete();

                    if($deals){

                        Session::put('success','Successfully Updated ');

                        return redirect()->back();

                        }

                       }

                   public function deals_update(Request $request){

                    $this->validate($request,[

                        'description'=>'string|required',

                        'days'=>'string|required',

                    ]);

                    $deals=DB::table('deals_of_day')->where('status','active')->update(['description'=>$request->description,'days'=>$request->days]);

                    if($deals){

                        Session::put('success','Successfully Updated ');

                        return redirect()->back();

                        }else{

                            return back()->with('error','something went worng!');

                        }

                       }

    /**

     * Show the form for creating a new resource.

     *

     * @return \Illuminate\Http\Response

     */

}
