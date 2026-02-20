<?php

namespace App\Http\Controllers;
use App\Models\Category;
use DB;
use App\Models\CategoryTag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Session;

class CategoryTagController extends Controller
{
    // Show the form for creating a new category tag
    public function index()
    {
        $tags = CategoryTag::orderBy('id', 'DESC')->get();
        return view('backend.category_tag.view', compact('tags'));
    }

    public function create()
    {
        // $categories = DB::table('categories')->where('status','active')->get();

        //   $categories = Category::where('sub_cate_id', null)->whereNotNull('parent_id')->orderBy('id', 'DESC')->get();
        $categories = Category::where('status', 'active')
        ->orderBy('id', 'desc')
        ->get();

          return view('backend.category_tag.add',compact('categories'));
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
        'status' => 'required|nullable|in:active,inactive',
        'category' => 'required|exists:categories,slug',  // Ensure category exists
    ]);

    if ($validate->fails()) {
        Session::put('errors', $validate->errors());
        return redirect()->back();
    }

    // Get the category ID from the categories table
    $category = Category::where('slug', $request->input('category'))->first();

    // If no category found, return with error
    if (!$category) {
        return back()->with('error', 'Category not found');
    }

    // Prepare the data to save into the categorytag table
    $data = $request->all();
    $slug = Str::slug($request->input('title'));
    $data['categories_id'] = $category->id;  // Store the category ID
    $data['link'] = $request->category;

    // Create a new CategoryTag
    $status = CategoryTag::create($data);

    if ($status) {
        Session::put('success', 'Successfully created category tag');
        return redirect()->route('categorytag.index');
    } else {
        return back()->with('error', 'Something went wrong!');
    }
}

    public function store23(Request $request)
    {
        $validate = Validator::make($request->all(), [
            // 'photo'=>'required',

            //'mobile_photo'=>'required',

            // 'condition'=>'nullable|in:banner,promo',
            'status'=>'required|nullable|in:active,inactive',
        ],

        [
            // 'photo.required' => 'Photo field is required',
            //'mobile_photo.required' => 'MObile Photo field is required',
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

         $data['link']=$request->category;
        // return $data;
        $status=CategoryTag::create($data);
        if($status){
            Session::put('success','Successfully created banner');
           return redirect()->route('categorytag.index');

        }else{
            return back()->with('error','something went worng!');
        }
    }

    public function getCategories($isParent)
{
    if ($isParent === 'FC') {
        $categories = Category::where('status', '=', 'active')
                               ->orderBy('id', 'DESC')
                               ->get();
    } elseif ($isParent === 'PP') {
        $categories = Category::where('is_parent', 0)
                               ->where('status', '=', 'active')
                               ->orderBy('id', 'DESC')
                               ->get();
    } else {
        $categories = [];
    }

    return response()->json(['categories' => $categories]);
}

    public function getCategories43242($isParent)
    {
        // Fetch categories based on `is_parent` value
        $categories = Category::where('is_parent', $isParent)->where('status', '=', 'active')->orderBy('id', 'DESC')->get();

        return response()->json(['categories' => $categories]);
    }

    public function CategorytagStatus(Request $request)
    {
    //    dd($request->all());
    $categorytag=DB::table('categorytag')->where('id',$request->id)->first();
    if($categorytag->status=='inactive'){
        DB::table('categorytag')->where('id',$request->id)->update(['status'=>'active']);
    }
    else{
        DB::table('categorytag')->where('id',$request->id)->update(['status'=>'inactive']);
    }
    return response()->json(['msg'=>'Successfully update status','status'=>true]);
    }

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

        $categorytag=CategoryTag::find($id);
    // $categories = DB::table('categories')->where('sub_cate_id', null)->whereNotNull('parent_id')->where('status','active')->get();
    $categories = DB::table('categories')->where('status','active')->get();
        if($categorytag){
            return view('backend.category_tag.edit',compact('categorytag','categories'));
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

     public function update231(Request $request, $id)
{
    $categorytag = CategoryTag::find($id);

    if ($categorytag) {
        $validate = Validator::make($request->all(), [
            'photo' => 'required',
        ]);

        if ($validate->fails()) {
            Session::put('errors', $validate->errors());
            return redirect()->back();
        }

        $data = $request->all();
        $data['link'] = $request->category;
        $status = $categorytag->fill($data)->save();

        if ($status) {
            Session::put('success', 'Successfully updated category tag');
            return redirect()->route('categorytag.index');
        } else {
            return back()->with('error', 'Something went wrong!');
        }
    } else {
        return back()->with('error', 'Data not found');
    }
}

    public function update(Request $request, $id)
    {

        $categorytag=CategoryTag::find($id);

        if($categorytag){
            // return view('backend.banner.edit',compact('banner'));
           // return $request->all();
           $validate = Validator::make($request->all(), [
            'photo'=>'required',
            // 'condition'=>'nullable|in:banner,promo',
         ]
        );
        if($validate->fails()){

            Session::put('errors',$validate->errors());
            // var_dump($validate->messages()->messages->photo[0]);
            // exit;
            return redirect()->back();
        }
        $data=$request->all();
         $data['link']=$request->category;
         $get_category_id = Category::where('slug', '=', $request->category)
                               ->first();
        $data['categories_id']=$get_category_id->id;
        $status=$categorytag->fill($data)->save();
        if($status){
            Session::put('success','Successfully update category tag');
           return redirect()->route('categorytag.index');

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
        $categorytag=CategoryTag::find($id);
        if($categorytag){
            $status=$categorytag->delete();
            if($status){
                Session::put('error','category tag successfully deleted');
                return redirect()->route('categorytag.index');
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
