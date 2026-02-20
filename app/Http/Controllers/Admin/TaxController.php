<?php

namespace App\Http\Controllers\Admin;

use App\Models\Tax;

use DB;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Session;

use Auth;

class TaxController extends Controller

{

     function __construct()

    {

         $this->middleware('permission:tax-view|tax-add|tax-edit|tax-delete', ['only' => ['index','store']]);

         $this->middleware('permission:tax-add', ['only' => ['create','store']]);

         $this->middleware('permission:tax-edit', ['only' => ['edit','update']]);

         $this->middleware('permission:tax-delete', ['only' => ['destroy']]);

        //  $this->userid=@Auth::user()->id;

        //  $this->username=@Auth::user()->name;

    }

    /**

     * Display a listing of the resource.

     *

     * @return \Illuminate\Http\Response

     */

    public function index()

    {

        $tax=Tax::orderBy('id','DESC')->get();

        return view('backend.tax.tax',compact('tax'));

    }

    /**

     * Show the form for creating a new resource.

     *

     * @return \Illuminate\Http\Response

     */

    public function create()

    {

        return view('backend.tax.tax-add');

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

            'tax_name'=>'required|string',

            'percentage'=>'required',

            'status'=>'required|in:active,inactive',

       ]);

       $data=$request->all();

    //   $data['created_by']=$this->userid;

       $status=Tax::create($data);

       if($status){

           Session::put('success','Tax successfully created');

           return redirect()->route('tax.index');

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

        $tax=Tax::find($id);

        if($tax){

            return view('backend.tax.tax-edit',compact('tax'));

        }

        else{

            return back()->with('error','Tax not  found');

        }

    }

    public function taxstatus(Request $request)

    {

    if($request->mode=='true'){

        DB::table('taxes')->where('id',$request->id)->update(['status'=>'active']);

    }

    else{

        DB::table('taxes')->where('id',$request->id)->update(['status'=>'inactive']);

    }

    return response()->json(['msg'=>'Successfully update status','status'=>true]);

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

        $tax=Tax::find($id);

        if($tax){

            $this->validate($request,[

                'tax_name'=>'required|string',

                'percentage'=>'required',

                'percentage1'=>'required',

                'status'=>'required|in:active,inactive',

           ]);

          $data=$request->all();

          $status=$tax->fill($data)->save();

          if($status){

              Session::put('success','Successfully updated Tax');

              return redirect()->route('tax.index');

          }else{

              return back()->with('error','something went worng!');

          }

        }else{

            return back()->with('error','Tax not fround');

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

        $tax=Tax::find($id);

        if($tax){

            $status=$tax->delete();

            if($status){

               Session::put('error','Tax successfully deleted');

                return redirect()->route('tax.index');

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
