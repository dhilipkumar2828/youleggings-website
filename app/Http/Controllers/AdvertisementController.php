<?php

namespace App\Http\Controllers;

use App\Models\Advertisement;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Redirect;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Auth;
class AdvertisementController extends Controller
{
  function __construct()
    {
         $this->middleware('permission:advertisement-view|advertisement-add|advertisement-edit|advertisement-delete', ['only' => ['index','store']]);
         $this->middleware('permission:advertisement-add', ['only' => ['create','store']]);
         $this->middleware('permission:advertisement-edit', ['only' => ['edit','update']]);
         $this->middleware('permission:advertisement-delete', ['only' => ['destroy']]);
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

          $advertisements = Advertisement::orderBy('id','DESC')->get();
            return view('backend.advertisement.view',compact('advertisements'));

    }

    public function advertisementStatus(Request $request)
    {
    //    dd($request->all());
    $advertisement=DB::table('advertisement')->where('id',$request->id)->first();
    if($advertisement->status=='inactive'){
        DB::table('advertisement')->where('id',$request->id)->update(['status'=>'active']);
    }
    else{
        DB::table('advertisement')->where('id',$request->id)->update(['status'=>'inactive']);
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
        return view('backend.advertisement.add');
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
        // return $request->all();
        // $request->validate([
        //     // 'title'=>'required',
        //     'photo'=>'string',
        //     // 'condition'=>'nullable|in:banner,promo',
        //     'status'=>'nullable|in:active,inactive',
        // ]);
        $data=$request->all();

        $slug=Str::slug($request->input('title'));

        // return $data;
        $status=Advertisement::create($data);
        if($status){
            Session::put('success','Successfully created Advertisement');
           return redirect()->route('advertisement.index');

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

        $advertisement=Advertisement::find($id);

        if($advertisement){
            return view('backend.advertisement.edit',compact('advertisement'));
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

        $advertisement=Advertisement::find($id);

        if($advertisement){
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
         $position = $request->position;
       // $position_update=DB::table('advertisement')->where('position',$position)->update(['position'=>'0']);

        $status=$advertisement->fill($data)->save();
        if($status){
            Session::put('success','Successfully update Advertisement');
           return redirect()->route('advertisement.index');

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
        $advertisement=Advertisement::find($id);
        if($advertisement){
            $status=$advertisement->delete();
            if($status){
                Session::put('error','Advertisement successfully deleted');
                return redirect()->route('advertisement.index');
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
