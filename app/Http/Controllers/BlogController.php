<?php

namespace App\Http\Controllers;

use Illuminate\Support\Str;

use App\Models\Blog;

use DB;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Session;

use Auth;

class BlogController extends Controller

{

    function __construct()
    {
         $this->middleware('permission:Blog List|Blog Create|Blog Edit|Blog Delete', ['only' => ['index','store']]);
         $this->middleware('permission:Blog Create', ['only' => ['create','store']]);
         $this->middleware('permission:Blog Edit', ['only' => ['edit','update']]);
         $this->middleware('permission:Blog Delete', ['only' => ['destroy']]);

         $this->middleware(function ($request, $next) {
             if (Auth::check()) {
                 $this->userid = Auth::user()->roles[0]->id;
                 $this->username = Auth::user()->roles[0]->name;
             }
             return $next($request);
         });
    }

    /**

     * Display a listing of the resource.

     *

     * @return \Illuminate\Http\Response

     */

    public function index()

    {

        $user=(Auth::user()->roles[0]->id == 1) ?['1'] : ['1',$this->userid];

        $blogs=Blog::orderBy('id','DESC')->get();

        $heading=DB::table('headings')->where('status','active')->where('type','blogs')->first();

        return view('backend.blog.view',compact('blogs','heading'));

    }

    /**

     * Show the form for creating a new resource.

     *

     * @return \Illuminate\Http\Response

     */

    public function create()

    {

        return view('backend.blog.add');

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

            'photo'=>'string',

            'publish_at'=>'required',

            'status'=>'required'

        ]);

        $data=$request->all();

        $slug=Str::slug($request->input('title'));

        $slug_count=Blog::where('slug',$slug)->count();

        if($slug_count>0){

            $slug .=time().'-'.$slug;

        }

        $data['slug']=$slug;

        // return $data;

        $blogs=Blog::create($data);

        if($blogs){

           Session::put('success','Successfully created Blog');

            return redirect()->route('blog.index');

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

        $blogs=Blog::find($id);

        if($blogs){

            return view('backend.blog.edit',compact('blogs'));

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

        $blogs=Blog::find($id);

        if($blogs){

            // return view('backend.banner.edit',compact('banner'));

           // return $request->all();

        $this->validate($request,[

            'title'=>'string|required',

            'description'=>'string|nullable',

            'photo'=>'string',

            'publish_at'=>'required',

            'status'=>'required'

        ]);

        $data=$request->all();

        $status=$blogs->fill($data)->save();

        if($status){

            Session::put('success','Successfully update About');

            return redirect()->route('blog.index');

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

        $blogs=Blog::find($id);

        if($blogs){

            $status=$blogs->delete();

            if($status){

               Session::put('success','Contact successfully deleted');

                return redirect()->route('blog.index');

            }

            else{

                return back()->with('error','Data not found');

            }

        }

    }

}
