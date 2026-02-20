<?php

namespace App\Http\Controllers;

use Illuminate\Support\Str;

use App\Models\Faqs;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Session;

class FaqsController extends Controller

{

      function __construct()

    {

         $this->middleware('permission:FAQS List|FAQS Create|FAQS Edit|FAQS Delete', ['only' => ['index','store']]);

         $this->middleware('permission:FAQS Create', ['only' => ['create','store']]);

         $this->middleware('permission:FAQS Edit', ['only' => ['edit','update']]);

         $this->middleware('permission:FAQS Delete', ['only' => ['destroy']]);

    }

    /**

     * Display a listing of the resource.

     *

     * @return \Illuminate\Http\Response

     */

    public function index()

    {

        $faqsus=Faqs::orderBy('id','DESC')->get();

            return view('backend.faqs.view',compact('faqsus'));

    }

    /**

     * Show the form for creating a new resource.

     *

     * @return \Illuminate\Http\Response

     */

    public function create()

    {

        return view('backend.faqs.add');

    }

    /**

     * Store a newly created resource in storage.

     *

     * @param  \Illuminate\Http\Request  $request

     * @return \Illuminate\Http\Response

     */

    public function store(Request $request)

    {

           // return $request->all();

           $this->validate($request,[

            'title'=>'string|required',

            'description'=>'string|nullable',

        ]);

        $data=$request->all();

        $slug=Str::slug($request->input('title'));

        $slug_count=Faqs::where('slug',$slug)->count();

        if($slug_count>0){

            $slug .=time().'-'.$slug;

        }

        $data['slug']=$slug;

        // return $data;

        $status=Faqs::create($data);

        if($status){

              Session::put('success','Successfully created Faqs');

            return redirect()->route('faqs.index');

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

        $faqsus=Faqs::find($id);

        if($faqsus){

            return view('backend.faqs.edit',compact('faqsus'));

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

        $faqsus=Faqs::find($id);

        if($faqsus){

            // return view('backend.banner.edit',compact('banner'));

           // return $request->all();

        $this->validate($request,[

            'title'=>'string|required',

            'description'=>'string|nullable',

        ]);

        $data=$request->all();

        $status=$faqsus->fill($data)->save();

        if($status){

            Session::put('success','Successfully update faqs');

            return redirect()->route('faqs.index');

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

        $faqsus=Faqs::find($id);

        if($faqsus){

            $status=$faqsus->delete();

            if($status){

               Session::put('error','Contact successfully deleted');

                return redirect()->route('faqs.index');

            }

            else{

                return back()->with('error','Data not found');

            }

        }

    }

}
