<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:category-view|category-add|category-edit|category-delete', ['only' => ['index', 'store']]);
        $this->middleware('permission:category-add', ['only' => ['create', 'store']]);
        $this->middleware('permission:category-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:category-delete', ['only' => ['destroy']]);
        $this->middleware('permission:homepage-sorting', ['only' => ['homepage_sorting']]);
        $this->middleware('permission:headerpage-sorting', ['only' => ['header_sorting']]);
        // $this->userid=@Auth::user()->id;
        // $this->username=@Auth::user()->name;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        // $user=(Auth::user()->roles[0]->id == 1) ?['1',$this->userid] : [$this->userid];
        $categories = Category::where('parent_id', null)->orderBy('id', 'DESC')->get();
        $subcategories = Category::where('parent_id', '!=', null)->groupBy('parent_id')->orderBy('id', 'DESC')->get();

        $subcategory = array();
        foreach ($subcategories as $key => $subcat) {
            array_push($subcategory, $subcat->parent_id);
        }

        return view('backend.categories.view', compact('categories', 'subcategory'));
    }

    public function categoryStatus(Request $request)
    {
        //    dd($request->all());
        if ($request->mode == 'true') {
            DB::table('categories')->where('id', $request->id)->update(['status' => 'active']);
        } else {
            DB::table('categories')->where('id', $request->id)->update(['status' => 'inactive']);
        }
        return response()->json(['msg' => 'Successfully update status', 'status' => true]);
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $parent_cate = Category::orderBy('id', 'DESC')->get();
        return view('backend.categories.add', compact('parent_cate'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // $this->validate($request,[
        //     'title'=>'string|required',
        //     'description'=>'string|nullable',
        //     'parent_id'=>'nullable|exists:categories,id',
        //     'met_keyword'=>'string|nullable',
        //     'met_description'=>'string|nullable',
        //     'status'=>'nullable|in:active,inactive',
        // ]);

        $data = $request->all();
        $slug = Str::slug($request->input('title'));
        $slug_count = Category::where('slug', $slug)->count();
        if ($slug_count > 0) {
            $slug .= time() . '-' . $slug;
        }
        $data['slug'] = $slug;
        if (isset($data['parent_category'])) {
            $data['is_parent'] = 1;
            $data['parent_id'] = $data['parent_category'];
        }

        // Handle file upload
        //   if ($request->hasFile('photo')) {
        //     $filenameWithExt = $request->file('photo')->getClientOriginalName();
        //     $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
        //     $extension = $request->file('photo')->getClientOriginalExtension();
        //     $fileNameToStore = $filename . '_' . time() . '.' . $extension;
        //     $path = $request->file('photo')->storeAs('public/photos', $fileNameToStore);
        //     print_r($data['photo']);
        //     exit;
        //     $data['photo'] = $fileNameToStore;
        // } else {
        //     $data['photo'] = 'noimage.jpg';
        // }

        $status = Category::create($data);
        // $categoryid=Category::orderBy('id','desc')->first();
        //  Category::where('id',$categoryid->id)->orderBy('id','desc')->update(['homeorder'=>$categoryid->id,'headerorder'=>$categoryid->id]);
        if ($status) {
            Session::put('success', 'Category successfully added');
            return redirect()->route('category.index');
        } else {
            return back()->with('error', 'something went worng!');
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
        $category = Category::find($id);
        $parent_cate = Category::where('parent_id', null)->orderBy('title', 'ASC')->get();
        $check_parent = Category::where('parent_id', $id)->get();

        if ($category) {

             $nextCategory = Category::where('parent_id', null)->where('id', '>', $id)->min('id');
            return view('backend.categories.edit', compact(['category', 'parent_cate', 'check_parent','nextCategory']));
        } else {
            return back()->with('error', 'Category not  found');
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

        $category = Category::find($id);

        if ($category) {

            $this->validate($request, [
                'title' => 'string|required',
                'description' => 'string|nullable',
                'parent_id' => 'nullable|exists:categories,id',
                'met_keyword' => 'string|nullable',
                'met_description' => 'string|nullable',
                'status' => 'nullable|in:active,inactive',
                'header' => 'nullable|in:active,inactive',
                'home' => 'nullable|in:active,inactive',
                'category' => 'nullable|in:active,inactive',
                'offers' => 'nullable|in:active,inactive',
            ]);
            if (isset($request->header)) {
                $request['header'] = $request->header;
            } else {
                $request['header'] = 'inactive';
            }
            if (isset($request->home)) {
                $request['home'] = $request->home;
            } else {
                $request['home'] = 'inactive';
            }
            //category edit
            if (isset($request->category) && $request->category == 'active') {
                $request['category'] = $request->category;
            } else {
                $request['category'] = 'inactive';
            }
            //offers edit
            if (isset($request->offers)) {
                $request['offers'] = $request->offers;
            } else {
                $request['offers'] = 'inactive';
            }

            $data = $request->all();
            //  dd($data);

            // $slug=Str::slug($request->input('title'));
            // $slug_count=Category::where('slug',$slug)->count();
            // if($slug_count>0){
            //     $slug .=time().'-'.$slug;
            // }
            // $data['slug']=$slug;
            // $data['is_parent']=2;
            // $data['created_by']=$this->userid;
            // return $data;
            $status = $category->fill($data)->save();
            if ($status) {
                Session::put('success', 'Successfully updated Category');
                return redirect()->route('category.index');

            } else {
                return back()->with('error', 'something went worng!');
            }

        } else {
            return back()->with('error', 'Category not fround');
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

        $category = Category::find($id);
        $child_cat_id = Category::where('parent_id', $id)->pluck('id');
        if ($category) {
            Category::where('parent_id', $id)->where('is_parent', 1)->delete();
            Product::where('category', $id)->update(['category' => 0, 'subcategory_id' => 0]);
            $status = $category->delete();

            if ($status) {
                if (count($child_cat_id) > 0) {
                    Category::shiftChild($child_cat_id);
                }

                Session::put('error', 'Category successfully deleted');

                return redirect()->route('category.index');
            } else {
                return back()->with('error', 'Data not found');
            }

        }
    }

    public function getChildByParentID(Request $request, $id)
    {
        $categories = Category::find($request->id);
        if ($categories) {
            $child_id = Category::getChildByParentID($request->id);
            if (count($child_id) <= 0) {
                return response()->json(['status' => false, 'data' => null, 'msg' => '']);
            }
            return response()->json(['status' => true, 'data' => $child_id, 'msg' => '']);
        } else {
            return response()->json(['status' => false, 'data' => null, 'msg' => 'Category not found']);
        }
    }

    //sub category
    public function subcategory_view(Request $request, $id)
    {

        return view('backend.subcategory.view');
    }

    public function category_sorting()
    {
        return view('backend.categories.sorting');
    }

    public function homepage_sorting(Request $request)
    {
        $category = Category::where('is_parent', 0)->where('home', 'active')->orderBy('homeorder', 'asc')->get();
        return view('backend.categories.homepage_sorting', compact('category'));
    }

    public function header_sorting(Request $request)
    {
        // $category = Category::where('is_parent', 0)->where('header', 'active')->orderBy('headerorder', 'asc')->get();
        $category = Category::where('is_parent', 0)->where('status', 'active')->orderBy('headerorder', 'asc')->get();
        return view('backend.categories.headerpage_sorting', compact('category'));
    }

    public function homeorder(Request $request)
    {
        $posts = Category::where('is_parent', 0)->where('home', 'actives')->get();

        foreach ($posts as $post) {
            foreach ($request->order as $order) {
                //   if ($order['id'] == $post->id) {
                //var_dump($order['position']);
                Category::where('is_parent', 0)->where('id', $order['id'])->update(['homeorder' => $order['position']]);
                //   }
            }
        }

    }

    public function headerorder(Request $request)
    {
        $posts = Category::where('is_parent', 0)->where('home', 'active')->get();

        foreach ($posts as $post) {
            foreach ($request->order as $order) {
                //    if ($order['id'] == $post->id) {

                Category::where('is_parent', 0)->where('id', $order['id'])->update(['headerorder' => $order['position']]);
                //   }
            }
        }

    }
     public function bulkDelete(Request $request)
    {
        $categoryIds = $request->input('category_ids');
        if ($categoryIds) {
            Category::whereIn('id', $categoryIds)->delete();
            return redirect()->back()->with('success', 'Selected categories have been deleted.');
        }

        return redirect()->back()->with('error', 'No categories selected.');
    }
}
