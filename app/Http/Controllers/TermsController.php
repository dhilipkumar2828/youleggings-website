<?php

namespace App\Http\Controllers;

use Illuminate\Support\Str;

use Illuminate\Http\Request;

use App\Models\Terms;

use Illuminate\Support\Facades\Session;

class TermsController extends Controller

{

     function __construct()

    {

        //  $this->middleware('permission:Terms List|Terms Create|Terms Edit|Terms Delete', ['only' => ['index','store']]);
        //  $this->middleware('permission:Terms Create', ['only' => ['create','store']]);
        //  $this->middleware('permission:Terms Edit', ['only' => ['edit','update']]);
        //  $this->middleware('permission:Terms Delete', ['only' => ['destroy']]);

    }

    /**

     * Display a listing of the resource.

     *

     * @return \Illuminate\Http\Response

     */

    public function index()

    {

        $terms_con=Terms::orderBy('id','DESC')->get();

        return view('backend.terms.view',compact('terms_con'));

    }

    /**

     * Show the form for creating a new resource.

     *

     * @return \Illuminate\Http\Response

     */

    public function create()

    {

        return view('backend.terms.add');

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

        $slug_count=Terms::where('slug',$slug)->count();

        if($slug_count>0){

            $slug .=time().'-'.$slug;

        }

        $data['slug']=$slug;

        // return $data;

        $status=Terms::create($data);

        if($status){

           Session::put('success','Successfully created Terms & Condition');

            return redirect()->route('terms.index');

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

        $terms_con=Terms::find($id);

        if($terms_con){

            return view('backend.terms.edit',compact('terms_con'));

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

        $terms_con=Terms::find($id);

        if($terms_con){

            // return view('backend.banner.edit',compact('banner'));

           // return $request->all();

        $this->validate($request,[

            'title'=>'string|required',

            'description'=>'string|nullable',

        ]);

        $data=$request->all();

        $status=$terms_con->fill($data)->save();

        if($status){

            Session::put('success','Successfully update Terms & Conditions');

            return redirect()->route('terms.index');

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

        $terms_con=Terms::find($id);

        if($terms_con){

            $status=$terms_con->delete();

            if($status){

                Session::put('error','Terms successfully deleted');

                return redirect()->route('terms.index');

            }

            else{

                return back()->with('error','Data not found');

            }

        }

    }

    }
