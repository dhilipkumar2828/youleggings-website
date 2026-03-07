<?php

namespace App\Http\Controllers\Admin;

use App\Models\Category;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;

use App\Http\Controllers\Controller;

use Illuminate\Support\Str;

use Illuminate\Support\Facades\Session;

use Auth;

class CategoryGroupController extends Controller

{

   function __construct()
    {
         $this->middleware('permission:Category Group List|Category Group Create|Category Group Edit|Category Group Delete', ['only' => ['index','store']]);
         $this->middleware('permission:Category Group Create', ['only' => ['create','store']]);
         $this->middleware('permission:Category Group Edit', ['only' => ['edit','update']]);
         $this->middleware('permission:Category Group Delete', ['only' => ['destroy']]);

         $this->middleware(function ($request, $next) {
             if (Auth::check()) {
                 $this->userid = Auth::user()->id;
                 $this->username = Auth::user()->name;
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

        $user=(Auth::user()->roles[0]->id == 1) ?['1',$this->userid] : [$this->userid];

        $categories=Category::whereIn('created_by',$user)->where('is_parent',1)->orderBy('id','DESC')->get();

        return view('backend.categories-group.view',compact('categories'));

    }

    public function categoryStatus(Request $request)

    {

    //    dd($request->all());

    if($request->mode=='true'){

        DB::table('categories')->where('id',$request->id)->update(['status'=>'active']);

    }

    else{

        DB::table('categories')->where('id',$request->id)->update(['status'=>'inactive']);

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

        $parent_cate=Category::where('is_parent',1)->orderBy('title','ASC')->get();

        return view('backend.categories-group.add',compact('parent_cate'));

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

            'met_keyword'=>'string|nullable',

            'met_description'=>'string|nullable',

            'status'=>'nullable|in:active,inactive',

        ]);

        $data=$request->all();

        $slug=Str::slug($request->input('title'));

        $slug_count=Category::where('slug',$slug)->count();

        if($slug_count>0){

            $slug .=time().'-'.$slug;

        }

        $data['slug']=$slug;

        $data['created_by']= $this->userid;

        $data['is_parent']=$request->input('is_parent') ? $request->input('is_parent') : 1 ;

        // return $data;

        $status=Category::create($data);

        if($status){

            Session::put('success','Category successfully added');

            return redirect()->route('category-group.index');

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

        $category=Category::find($id);

        $parent_cate=Category::where('is_parent',1)->orderBy('title','ASC')->get();

        if($category){

            return view('backend.categories-group.edit',compact(['category','parent_cate']));

        }

        else{

            return back()->with('error','Category not  found');

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

      $category=Category::find($id);

      if($category){

        $this->validate($request,[

            'title'=>'string|required',

            'description'=>'string|nullable',

            'met_keyword'=>'string|nullable',

            'met_description'=>'string|nullable',

            'status'=>'nullable|in:active,inactive',

        ]);

        $data=$request->all();

        // $slug=Str::slug($request->input('title'));

        // $slug_count=Category::where('slug',$slug)->count();

        // if($slug_count>0){

        //     $slug .=time().'-'.$slug;

        // }

        // $data['slug']=$slug;

        $data['is_parent']=$request->input('is_parent') ? $request->input('is_parent') : 1 ;

        // return $data;

        // $data['created_by']= $this->userid;

        $status=$category->fill($data)->save();

        if($status){

            Session::put('success','Successfully update Category');

            return redirect()->route('category-group.index');

        }else{

            return back()->with('error','something went worng!');

        }

      }else{

          return back()->with('error','Category not fround');

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

        $category=Category::find($id);

        $child_cat_id=Category::where('parent_id',$id)->pluck('id');

        if($category){

            $status=$category->delete();

             if($status){

                if(count($child_cat_id)>0){

                    Category::shiftChild($child_cat_id);

                }

                Session::put('error','Category successfully deleted');

                return redirect()->route('category-group.index');

            }

            else{

                return back()->with('error','Data not found');

            }

        }

    }

    public function getChildByParentID(Request $request,$id)

    {

        $categories=Category::find($request->id);

        if($categories){

            $child_id=Category::getChildByParentID($request->id);

        if(count($child_id)<=0){

            return response()->json(['status'=>false,'data'=>null,'msg'=>'']);

        }

        return response()->json(['status'=>true,'data'=>$child_id,'msg'=>'']);

        }

        else{

            return response()->json(['status'=>false,'data'=>null,'msg'=>'Category not found']);

        }

    }

}
