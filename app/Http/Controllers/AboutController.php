<?php

namespace App\Http\Controllers;

use Illuminate\Support\Str;

use App\Models\About;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Session;

class AboutController extends Controller

{

    function __construct()

    {

        //  $this->middleware('permission:About Us List|About Us Create|About Us Edit|About Us Delete', ['only' => ['index','store']]);
        //  $this->middleware('permission:About Us Create', ['only' => ['create','store']]);
        //  $this->middleware('permission:About Us Edit', ['only' => ['edit','update']]);
        //  $this->middleware('permission:About Us Delete', ['only' => ['destroy']]);

    }

    /**

     * Display a listing of the resource.

     *

     * @return \Illuminate\Http\Response

     */

    public function index()

    {

        $aboutus=About::orderBy('id','DESC')->get();

            return view('backend.about.view',compact('aboutus'));

    }

    /**

     * Show the form for creating a new resource.

     *

     * @return \Illuminate\Http\Response

     */

    public function create()

    {

        return view('backend.about.add');

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
            'sub_title'=>'string|nullable',
            'description'=>'string|nullable',
            'photo'=>'string',
            'promise_title'=>'string|nullable',
            'promise_desc'=>'string|nullable',
            'why_choose_1_title'=>'string|nullable', 'why_choose_1_desc'=>'string|nullable',
            'why_choose_2_title'=>'string|nullable', 'why_choose_2_desc'=>'string|nullable',
            'why_choose_3_title'=>'string|nullable', 'why_choose_3_desc'=>'string|nullable',
            'why_choose_4_title'=>'string|nullable', 'why_choose_4_desc'=>'string|nullable',
            'why_choose_5_title'=>'string|nullable', 'why_choose_5_desc'=>'string|nullable',
        ]);

        $data=$request->all();
        $slug=Str::slug($request->input('title'));
        $slug_count=About::where('slug',$slug)->count();

        if($slug_count>0){
            $slug .=time().'-'.$slug;
        }

        $data['slug']=$slug;
        $status=About::create($data);

        if($status){
             Session::put('success','Successfully created About');
           return redirect()->route('about.index');
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

        $aboutus=About::find($id);

        if($aboutus){

            return view('backend.about.edit',compact('aboutus'));

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
        $aboutus=About::find($id);

        if($aboutus){
            $this->validate($request,[
                'title'=>'string|required',
                'sub_title'=>'string|nullable',
                'description'=>'string|nullable',
                'photo'=>'string',
                'promise_title'=>'string|nullable',
                'promise_desc'=>'string|nullable',
                'why_choose_1_title'=>'string|nullable', 'why_choose_1_desc'=>'string|nullable',
                'why_choose_2_title'=>'string|nullable', 'why_choose_2_desc'=>'string|nullable',
                'why_choose_3_title'=>'string|nullable', 'why_choose_3_desc'=>'string|nullable',
                'why_choose_4_title'=>'string|nullable', 'why_choose_4_desc'=>'string|nullable',
                'why_choose_5_title'=>'string|nullable', 'why_choose_5_desc'=>'string|nullable',
            ]);

            $data=$request->all();
            $status=$aboutus->fill($data)->save();

            if($status){
               Session::put('success','Successfully update About');
                return redirect()->route('about.index');
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

        $aboutus=About::find($id);

        if($aboutus){

            $status=$aboutus->delete();

            if($status){

                Session::put('error','Contact successfully deleted');

                return redirect()->route('about.index');

            }

            else{

                return back()->with('error','Data not found');

            }

        }

    }

}
