<?php

namespace App\Http\Controllers;

use App\Models\Youtube;

use Illuminate\Support\Str;

use Illuminate\Http\Request;

use Redirect;

use Illuminate\Support\Facades\Validator;

use Illuminate\Support\Facades\DB;

use Illuminate\Support\Facades\Session;

use Auth;

class youtubeController extends Controller

{

  function __construct()

    {

        //  $this->middleware('permission:youtube-view|youtube-add|youtube-edit|youtube-delete', ['only' => ['index','store']]);

        //  $this->middleware('permission:youtube-add', ['only' => ['create','store']]);

        //  $this->middleware('permission:youtube-edit', [  'only' => ['edit','update']]);

        //  $this->middleware('permission:youtube-delete', ['only' => ['destroy']]);

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

          $youtubes = Youtube::orderBy('id','DESC')->get();

            return view('backend.youtube.view',compact('youtubes'));

    }

    public function youtubeStatus(Request $request)

    {

    //    dd($request->all());

    $youtube=DB::table('youtube')->where('id',$request->id)->first();

    if($youtube->status=='inactive'){

        DB::table('youtube')->where('id',$request->id)->update(['status'=>'active']);

    }

    else{

        DB::table('youtube')->where('id',$request->id)->update(['status'=>'inactive']);

    }

     return redirect()->back();

    return response()->json(['msg'=>'Successfully update status','status'=>true]);

    }

    /**

     * Show the form for creating a new resource.

     *

     * @return \Illuminate\Http\Response

     */

    public function create()

    {

        return view('backend.youtube.add');

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

            'url'=>'required|nullable',

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

        $slug=Str::slug($request->input('url'));

        // return $data;

        $status=Youtube::create($data);

        if($status){

            Session::put('success','Successfully created Youtube');

           return redirect()->route('youtube.index');

        }else{

            return back()->with('error','something went worng!');

        }

    }

     /**

     * Show the form for editing the specified resource.

     *

     * @param  int  $id

     * @return \Illuminate\Http\Response

     */

    public function edit(Request $request,$id)

    {

        $youtubes=Youtube::find($id);

        if($youtubes){

            return view('backend.youtube.edit',compact('youtubes'));

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

        $youtubes=Youtube::find($id);

        if($youtubes){

            // return view('backend.banner.edit',compact('banner'));

           // return $request->all();

           $validate = Validator::make($request->all(), [

            'photo'=>'required',

            // 'condition'=>'nullable|in:banner,promo',

            'status'=>'required|nullable|in:active,inactive',

         ],

        [

            'photo.required' => 'Photo field is required',

        ]

        );

        if($validate->fails()){

            Session::put('errors',$validate->errors());

            // var_dump($validate->messages()->messages->photo[0]);

            // exit;

            return redirect()->back();

        }

        $data=$request->all();

        $status=$youtubes->fill($data)->save();

        if($status){

            Session::put('success','Successfully updated Youtube');

           return redirect()->route('youtube.index');

        }else{

            return back()->with('error','something went worng!');

        }

        }

        else{

            return back()->with('error','Data not  found');

        }

    }

    public function destroy($id)

    {

        // Logic to delete the resource

        // For example:

        $resource = Youtube::find($id);

        if ($resource) {

            $resource->delete();

             return redirect()->back();

        } else {

           return redirect()->back();

        }

    }

}
