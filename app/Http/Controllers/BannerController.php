<?php

namespace App\Http\Controllers;

use App\Models\Banner;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Redirect;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Auth;
use App\Models\Category;
class BannerController extends Controller
{
  function __construct()
    {
        //  $this->middleware('permission:banner-view|banner-add|banner-edit|banner-delete', ['only' => ['index','store']]);
        //  $this->middleware('permission:banner-add', ['only' => ['create','store']]);
        //  $this->middleware('permission:banner-edit', ['only' => ['edit','update']]);
        //  $this->middleware('permission:banner-delete', ['only' => ['destroy']]);
        //  $this->userid=@Auth::user()->roles[0]->id;
        //  $this->username=@Auth::user()->roles[0]->name;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

           $banners=Banner::orderBy('id','DESC')->get();
            return view('backend.banner.view',compact('banners'));

    }

    public function bannerStatus(Request $request)
    {
    //    dd($request->all());
    $banner=DB::table('banners')->where('id',$request->id)->first();
    if($banner->status=='inactive'){
        DB::table('banners')->where('id',$request->id)->update(['status'=>'active']);
    }
    else{
        DB::table('banners')->where('id',$request->id)->update(['status'=>'inactive']);
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
        // $categories = DB::table('categories')->where('status','active')->get();

        //   $categories = Category::where('sub_cate_id', null)->whereNotNull('parent_id')->orderBy('id', 'DESC')->get();
        //   $categories = Category::orderBy('id', 'DESC')->get();
          $categories = Category::where('status','active')
         -> orderBy('id', 'DESC')->get();

        return view('backend.banner.add',compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'photo'=>'required',
            'title'=>'nullable|string',
            'subtitle'=>'nullable|string',
            'status'=>'required|nullable|in:active,inactive',
        ],

        [
            'photo.required' => 'Photo field is required',

        ]
        );
        if($validate->fails()){

            Session::put('errors',$validate->errors());
            return redirect()->back();
        }
        
        $data=$request->all();
        $data['link']=$request->category;
        
        $status=Banner::create($data);
        if($status){
            Session::put('success','Successfully created banner');
           return redirect()->route('banner.index');

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
    public function edit(Request $request,$id)
    {

        $banner=Banner::find($id);
    // $categories = DB::table('categories')->where('sub_cate_id', null)->whereNotNull('parent_id')->where('status','active')->get();
    $categories = DB::table('categories')->where('status','active')->get();
        if($banner){
            return view('backend.banner.edit',compact('banner','categories'));
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

        $banner=Banner::find($id);

        if($banner){
           $validate = Validator::make($request->all(), [
            'photo'=>'required',
            'title'=>'nullable|string',
            'subtitle'=>'nullable|string',
            'status'=>'required|nullable|in:active,inactive',
         ],

        [
            'photo.required' => 'Photo field is required',
        ]
        );
        if($validate->fails()){

            Session::put('errors',$validate->errors());
            return redirect()->back();
        }
        $data=$request->all();
        $data['link']=$request->category;
        $status=$banner->fill($data)->save();
        if($status){
            Session::put('success','Successfully update banner');
           return redirect()->route('banner.index');

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
        $banner=Banner::find($id);
        if($banner){
            $status=$banner->delete();
            if($status){
                Session::put('error','Banner successfully deleted');
                return redirect()->route('banner.index');
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
