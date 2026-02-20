<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use App\Models\Warehouse;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Session;

use Auth;

class WarehouseController extends Controller

{

      function __construct()

    {

         $this->middleware('permission:Warehouse List|Warehouse Create|Warehouse Edit|Warehouse Delete', ['only' => ['index','store']]);

         $this->middleware('permission:Warehouse Create', ['only' => ['create','store']]);

         $this->middleware('permission:Warehouse Edit', ['only' => ['edit','update']]);

         $this->middleware('permission:Warehouse Delete', ['only' => ['destroy']]);

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

        $warehouse=Warehouse::whereIn('created_by',$user)->orderBy('id','DESC')->get();

        return view('backend.inventory.warehouse',compact('warehouse'));

    }

    /**

     * Show the form for creating a new resource.

     *

     * @return \Illuminate\Http\Response

     */

    public function create()

    {

        return view('backend.inventory.warehouse-create');

    }

    /**

     * Store a newly created resource in storage.

     *

     * @param  \Illuminate\Http\Request  $request

     * @return \Illuminate\Http\Response

     */

    public function store(Request $request)

    {

        $data=$request->all();

        $data['created_by']=$this->userid;

        $data['business_days']= implode(',',$data['business_days']);

        $status=Warehouse::create($data);

        if($status){

            Session::put('success','Warehouse create successfully');

            return redirect()->route('warehouse.index');

        }

        else{

            return back()->with('error','Data not found');

        }

    }

    public function warehouse_status(Request $request)

    {

    //    dd($request->all());

    if($request->mode=='true'){

        DB::table('warehouse')->where('id',$request->id)->update(['status'=>'active']);

    }

    else{

        DB::table('warehouse')->where('id',$request->id)->update(['status'=>'inactive']);

    }

    return response()->json(['msg'=>'Successfully update status','status'=>true]);

    }

    /**

     * Display the specified resource.

     *

     * @param  \App\Models\Warehouse  $warehouse

     * @return \Illuminate\Http\Response

     */

    public function show(Warehouse $warehouse)

    {

        //

    }

    /**

     * Show the form for editing the specified resource.

     *

     * @param  \App\Models\Warehouse  $warehouse

     * @return \Illuminate\Http\Response

     */

    public function edit($id)

    {

        $warehouse=Warehouse::find($id);

        return view('backend.inventory.warehouse-update',compact('warehouse'));

    }

    /**

     * Update the specified resource in storage.

     *

     * @param  \Illuminate\Http\Request  $request

     * @param  \App\Models\Warehouse  $warehouse

     * @return \Illuminate\Http\Response

     */

    public function update(Request $request, $id)

    {

        $warehouse=Warehouse::find($id);

        if($warehouse){

            $data=$request->all();

            $data['business_days']= implode(',',$data['business_days']);

            $status=$warehouse->fill($data)->save();

            if($status){

                Session::put('success','Successfully update Warehouse');

                return redirect()->route('warehouse.index');

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

     * @param  \App\Models\Warehouse  $warehouse

     * @return \Illuminate\Http\Response

     */

    public function destroy($id)

    {

        $warehouse=Warehouse::find($id);

        if($warehouse){

            $status=$warehouse->delete();

            if($status){

                Session::put('success','Warehouse successfully deleted');

                return redirect()->route('warehouse.index');

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
