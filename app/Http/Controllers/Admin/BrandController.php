<?php

namespace App\Http\Controllers\Admin;

use App\Models\Brand;

use Illuminate\Support\Str;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;

use Illuminate\Support\Facades\Storage;

use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\Session;

use Auth;

class BrandController extends Controller

{

  function __construct()

    {

         $this->middleware('permission:Brand List|Brand Create|Brand Edit|Brand Delete', ['only' => ['index','store']]);

         $this->middleware('permission:Brand Create', ['only' => ['create','store']]);

         $this->middleware('permission:Brand Edit', ['only' => ['edit','update']]);

         $this->middleware('permission:Brand Delete', ['only' => ['destroy']]);

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

        $user=(Auth::user()->roles[0]->id == 1) ?['1',$this->userid] : [$this->userid];

        $Brands=Brand::whereIn('created_by',$user)->orderBy('id','DESC')->get();

        return view('backend.brands.view',compact('Brands'));

    }

    public function brandStatus(Request $request)

    {

    //    dd($request->all());

    if($request->mode=='true'){

        DB::table('brands')->where('id',$request->id)->update(['status'=>'active']);

    }

    else{

        DB::table('brands')->where('id',$request->id)->update(['status'=>'inactive']);

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

        // $parent_cate=Brand::where('is_parent',1)->orderBy('title','ASC')->get();,compact('parent_cate')

        return view('backend.brands.add');

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

             'title'=>'nullable|string',

             'url'=>'nullable|string',

             'email'=>'nullable|string',

             'phone_number'=>'nullable|string',

             'description'=>'nullable|string',

             'brand_logo'=>'required',

             'cover_photo'=>'required',

             'status'=>'nullable|in:active,inactive',

        ]);

        $data=$request->all();

        $slug=Str::slug($request->input('title'));

        $slug_count=Brand::where('slug',$slug)->count();

        if($slug_count>0){

            $slug .=time().'-'.$slug;

        }

        $data['slug']=$slug;

        $data['created_by']=$this->userid;

        $status=Brand::create($data);

        if($status){

            Session::put('success','Manufacturers successfully created');

            return redirect()->route('brand.index');

        }

        else{

            Session::put('error','Error, Please try again');

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

        $Brand=Brand::find($id);

        if($Brand){

            return view('backend.brands.edit',compact('Brand'));

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

        $Brand=Brand::find($id);

        if($Brand){

            // return view('backend.banner.edit',compact('banner'));

           // return $request->all();

           $this->validate($request,[

            'title'=>'nullable|string',

            'url'=>'nullable|string',

            'email'=>'nullable|string',

            'phone_number'=>'nullable|string',

            'description'=>'nullable|string',

            'brand_logo'=>'required',

            'cover_photo'=>'required',

            'status'=>'nullable|in:active,inactive',

       ]);

        $data=$request->all();

        // $slug=Str::slug($request->input('title'));

        // $slug_count=Banner::where('slug',$slug)->count();

        // if($slug_count>0){

        //     $slug .=time().'-'.$slug;

        // }

        // $data['slug']=$slug;

        // // return $data;

        $status=$Brand->fill($data)->save();

       if($status){

            Session::put('success','Manufacturers Successfully updated');

            return redirect()->route('brand.index');

        }else{

            Session::put('error','something went worng!');

        }

        }

        else{

            Session::put('error','Data not  found');

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

        $Brand=Brand::find($id);

        if($Brand){

            $status=$Brand->delete();

            if($status){

                Session::put('error','Manufacturers successfully deleted');

                return redirect()->route('brand.index');

            }

            else{

                Session::put('success','Data not found');

            }

        }

        else{

            Session::put('error','Data not  found');

        }

    }

public function brand_show(request $request)

{

   $id=$request->id;

    $brand=Brand::find($id);

    //print_r($product);

    //echo $coupon->coupon_code;

    //$product=Category::where('id',$product->cat_id)->first();

    $title=html_entity_decode($brand->title);

    //$slug=html_entity_decode($brand->slug);

    $image="<img src='$brand->photo' alt=''style='max-height: 350px;max-width:350px' id='image'>";

    $photo=explode(',',$brand->photo);

    $photo=$photo[0];

    //return response()->json(['title'=> $title,'summary'=> $summary,'photo'=> explode(',',$product->photo)[0],'description'=>$description,'price'=> $price,'offer_price'=> $offer_price,'discount'=>$discount,'stock'=> $product->stock,'category'=> $categories->title,'sub_category'=> $sub_cat,'brand'=> $brand->title,'size'=> $product->size,'conditions'=> $product->conditions,'status'=> $product->status]);

    return response()->json(['title'=> $title,'photo'=> $photo,'status'=> $brand->status]);

}

}
