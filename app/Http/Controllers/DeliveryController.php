<?php

namespace App\Http\Controllers;

use Illuminate\Support\Str;

use Illuminate\Http\Request;

use App\Models\Delivery;

use Illuminate\Support\Facades\Session;

class DeliveryController extends Controller

{

    function __construct()

    {

         $this->middleware('permission:Delivery List|Delivery Create|Delivery Edit|Delivery Delete', ['only' => ['index','store']]);

         $this->middleware('permission:Delivery Create', ['only' => ['create','store']]);

         $this->middleware('permission:Delivery Edit', ['only' => ['edit','update']]);

         $this->middleware('permission:Delivery Delete', ['only' => ['destroy']]);

    }

    /**

     * Display a listing of the resource.

     *

     * @return \Illuminate\Http\Response

     */

    public function index()

    {

        $delivery_return=Delivery::orderBy('id','DESC')->get();

        return view('backend.delivery.view',compact('delivery_return'));

    }

    /**

     * Show the form for creating a new resource.

     *

     * @return \Illuminate\Http\Response

     */

    public function create()

    {

        return view('backend.delivery.add');

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

            'title'=>'string|required',

            'description'=>'string|nullable',

        ]);

        $data=$request->all();

        $slug=Str::slug($request->input('title'));

        $slug_count=Delivery::where('slug',$slug)->count();

        if($slug_count>0){

            $slug .=time().'-'.$slug;

        }

        $data['slug']=$slug;

        // return $data;

        $status=Delivery::create($data);

        if($status){

           Session::put('success','Successfully created Delivery & Returns');

           return redirect()->route('delivery.index');

        }else{

            return back()->with('error','something went worng!');

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

        $delivery_con=Delivery::find($id);

        if($delivery_con){

            return view('backend.delivery.edit',compact('delivery_con'));

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

        $delivery_con=Delivery::find($id);

        if($delivery_con){

            // return view('backend.banner.edit',compact('banner'));

           // return $request->all();

        $this->validate($request,[

            'title'=>'string|required',

            'description'=>'string|nullable',

        ]);

        $data=$request->all();

        $status=$delivery_con->fill($data)->save();

        if($status){

             Session::put('success','Successfully update Delivery & Returns');

            return redirect()->route('delivery.index');

        }else{

            return back()->with('error','something went worng!');

        }

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

        $delivery_con=Delivery::find($id);

        if($delivery_con){

            $status=$delivery_con->delete();

            if($status){

                Session::put('error','Delivery & Returns successfully deleted');

                return redirect()->route('delivery.index');

            }

            else{

                return back()->with('error','Data not found');

            }

        }

    }

    }
