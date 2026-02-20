<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use App\Models\Promo;

use Illuminate\Support\Facades\DB;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Session;

use Auth;

class PromoController extends Controller

{

    function __construct()

    {

         $this->middleware('permission:Promo List|Promo Create|Promo Edit|Promo Delete', ['only' => ['index','store']]);

         $this->middleware('permission:Promo Create', ['only' => ['create','store']]);

         $this->middleware('permission:Promo Edit', ['only' => ['edit','update']]);

         $this->middleware('permission:Promo Delete', ['only' => ['destroy']]);

         $this->userid=@Auth::user()->id;

         $this->username=@Auth::user()->name;

    }

    /**

     * Display a listing of the resource.

     *

     * @return \Illuminate\Http\Response

     */

    public function index()

    {

        $user=(Auth::user()->roles[0]->id == 1) ?['1',$this->userid] : [$this->userid];

        $promo = Promo::whereIn('created_by',$user)->orderBy('id','DESC')->get();

        return view('backend.promo.view',compact('promo'));

    }

    public function promo_status(Request $request)

    {

    //    dd($request->all());

    if($request->mode=='true'){

        DB::table('promos')->where('id',$request->id)->update(['status'=>'active']);

    }

    else{

        DB::table('promos')->where('id',$request->id)->update(['status'=>'inactive']);

    }

    return response()->json(['msg'=>'Successfully update status','status'=>true]);

    }

    /**

     * Show the form for creating a new resource.

     *

     * @return \Illuminate\Http\Response

     */

    public function create()

    {

        return view('backend.promo.add');

    }

    /**

     * Store a newly created resource in storage.

     *

     * @param  \Illuminate\Http\Request  $request

     * @return \Illuminate\Http\Response

     */

    public function store(Request $request)

    {

        $this->validate($request,[

            'Session_left_1'=>'required',

            'Session_right_1'=>'required',

            'Session_left_2'=>'required',

            'Session_right_2'=>'required',

            'Session_left_description1'=>'string|nullable',

            'Session_right_description1'=>'string|nullable',

            'Session_left_description2'=>'string|nullable',

            'Session_right_description2'=>'string|nullable',

            'status'=>'nullable|in:active,inactive',

       ]);

       $data=$request->all();

       $data['created_by']=$this->userid;

       $status=Promo::create($data);

       if($status){

          Session::put('success','Promo successfully created');

           return redirect()->route('promo.index');

       }

       else{

           return back()->with('error','Something went wrong');

       }

    }

    /**

     * Display the specified resource.

     *

     * @param  int  $id

     * @return \Illuminate\Http\Response

     */

    public function show($id)

    {

        //

    }

    /**

     * Show the form for editing the specified resource.

     *

     * @param  int  $id

     * @return \Illuminate\Http\Response

     */

    public function edit($id)

    {

        $promo=Promo::find($id);

        if($promo){

            return view('backend.promo.edit',compact('promo'));

        }

        else{

            return back()->with('error','Data not  found');

        }

    }

    /**

     * Update the specified resource in storage.

     *

     * @param  \Illuminate\Http\Request  $request

     * @param  int  $id

     * @return \Illuminate\Http\Response

     */

    public function update(Request $request, $id)

    {

        $promo=Promo::find($id);

        if($promo){

            // return view('backend.banner.edit',compact('banner'));

           // return $request->all();

        $this->validate($request,[

            'Session_left_1'=>'required',

            'Session_right_1'=>'required',

            'Session_left_2'=>'required',

            'Session_right_2'=>'required',

            'Session_left_description1'=>'string|nullable',

            'Session_right_description1'=>'string|nullable',

            'Session_left_description2'=>'string|nullable',

            'Session_right_description2'=>'string|nullable',

            'status'=>'nullable|in:active,inactive',

        ]);

        $data=$request->all();

        // $slug=Str::slug($request->input('title'));

        // $slug_count=Banner::where('slug',$slug)->count();

        // if($slug_count>0){

        //     $slug .=time().'-'.$slug;

        // }

        // $data['slug']=$slug;

        // // return $data;

        $status=$promo->fill($data)->save();

        if($status){

            Session::put('success','Successfully update promo');

            return redirect()->route('promo.index');

        }else{

            return back()->with('error','something went worng!');

        }

        }

        else{

            return back()->with('error','Data not  found');

        }

    }

    /**

     * Remove the specified resource from storage.

     *

     * @param  int  $id

     * @return \Illuminate\Http\Response

     */

    public function destroy($id)

    {

        $promo=Promo::find($id);

        if($promo){

            $status=$promo->delete();

            if($status){

                Session::put('error','promo successfully deleted');

                return redirect()->route('promo.index');

            }

            else{

                return back()->with('error','Data not found');

            }

        }

        else{

            return back()->with('error','Data not  found');

        }

    }

}
