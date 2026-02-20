<?php

namespace App\Http\Controllers;

use Illuminate\Support\Str;

use Illuminate\Http\Request;

use App\Models\Privacy;

use Illuminate\Support\Facades\Session;

class PrivacyController extends Controller

{

      function __construct()

    {

         $this->middleware('permission:Privacy List|Privacy Create|Privacy Edit|Privacy Delete', ['only' => ['index','store']]);

         $this->middleware('permission:Privacy Create', ['only' => ['create','store']]);

         $this->middleware('permission:Privacy Edit', ['only' => ['edit','update']]);

         $this->middleware('permission:Privacy Delete', ['only' => ['destroy']]);

    }

    /**

     * Display a listing of the resource.

     *

     * @return \Illuminate\Http\Response

     */

    public function index()

    {

        $privacy_pol=Privacy::orderBy('id','DESC')->get();

        return view('backend.privacy.view',compact('privacy_pol'));

    }

    /**

     * Show the form for creating a new resource.

     *

     * @return \Illuminate\Http\Response

     */

    public function create()

    {

        return view('backend.privacy.add');

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

        $slug_count=Privacy::where('slug',$slug)->count();

        if($slug_count>0){

            $slug .=time().'-'.$slug;

        }

        $data['slug']=$slug;

        // return $data;

        $status=Privacy::create($data);

        if($status){

           Session::put('success','Successfully created Privacy Policy');

            return redirect()->route('privacy.index');

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

        $privacy_pol=Privacy::find($id);

        if($privacy_pol){

            return view('backend.privacy.edit',compact('privacy_pol'));

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

        $privacy_pol=Privacy::find($id);

        if($privacy_pol){

            // return view('backend.banner.edit',compact('banner'));

           // return $request->all();

        $this->validate($request,[

            'title'=>'string|required',

            'description'=>'string|nullable',

        ]);

        $data=$request->all();

        $status=$privacy_pol->fill($data)->save();

        if($status){

               Session::put('success','Successfully update Privacy Policy');

            return redirect()->route('privacy.index');

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

        $privacy_pol=Privacy::find($id);

        if($privacy_pol){

            $status=$privacy_pol->delete();

            if($status){

                Session::put('error','Privacy Policy successfully deleted');

               return redirect()->route('privacy.index');

            }

            else{

                return back()->with('error','Data not found');

            }

        }

    }

    }
