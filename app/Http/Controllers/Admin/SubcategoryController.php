<?php

namespace App\Http\Controllers\Admin;

use App\Models\Category;
use App\Models\Product;;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Session;
use Auth;
class SubcategoryController extends Controller
{

    public function view(Request $request,$id){
        $subcategories=Category::where('parent_id','=',$id)->get();
        return view('backend.subcategory.view',compact('subcategories'));
    }

     public function edit(Request $request,$id){

       $subcategory=Category::where('id','=',$id)->first();
       $parent_cate=Category::where('parent_id',null)->get();
       $child_cate=Category::where('sub_cate_id',$id)->get();

       return view('backend.subcategory.edit',compact('subcategory','parent_cate','child_cate'));
   }

   public function update(Request $request,$id){

    if(isset($request->header)){
        $request['header']=$request->header;
     }
     else{
        $request['header']='inactive';
        }
     if(isset($request->home)){
        $request['home']=$request->home;
        }
        else{
        $request['home']='inactive';
        }

      $subcategory_photo = $request->photo;
             if(!empty($subcategory_photo)){
                    $photo = $subcategory_photo;
                    }

        if($request->child_category){

            foreach($request->child_category as $key => $vals){

                    $child_category = $request->child_category[$key];
                      $childCategoryId = $request->child_category_id[$key] ?? null;
                    if($child_category==''){

                         if ($childCategoryId) {
                            // Category::where('id', $childCategoryId)->delete();

                               $checkproduct = Product::where('childcategory_id', $childCategoryId)->count();

                            if ($checkproduct > 0) {
                                Session::put('error','This Child Category Contains Products, Delete Products and try Again!');

                                return back();
                            } else {
                                Category::where('id', $childCategoryId)->delete();
                            }

                        }

                        continue;
                    }

                     $slug = Str::slug($child_category);
                    $slug_count = Category::where('slug', $slug)->count();
                    if ($slug_count > 0) {
                        $slug .= time() . '-' . $slug;
                    }

                    $data =array(
                        'title'=>$child_category,
                        'slug'=>$slug,
                        'photo' => $photo,
                        'is_parent'=>1,
                        'status'=>'active',
                        'parent_id'=>$id,
                        'sub_cate_id'=>$id

                        );

                   if(isset($request->child_category_id[$key])){
                       $childcate_id = $request->child_category_id[$key];
                        $status=Category::where('id',$childcate_id)->update($data);

                   }else{

                       $status = Category::create($data);
                   }

            }
        }

        /*
        else{

             foreach($request->child_category as $key => $vals){

                    $child_category = $request->child_category[$key];

                    $slug = Str::slug($child_category);
                    $slug_count = Category::where('slug', $slug)->count();
                    if ($slug_count > 0) {
                        $slug .= time() . '-' . $slug;
                    }

                    $data =array(
                        'title'=>$child_category,
                        'slug'=>$slug,
                        'is_parent'=>1,
                        'status'=>'active',
                        'parent_id'=>$id,
                        'sub_cate_id'=>$id

                        );

             }

       }
       */
       $status=Category::where('id',$id)->update(['title'=>$request->title,'parent_id'=>$request->category,'header'=>$request->header,'home'=>$request->home,
       'photo' => $photo]);

     Product::where('subcategory_id',$id)->update(['category'=>$request->category]);

     $category_id=Category::where('id',$id)->first();
     if($status){
        Session::put('success','Sub Category successfully updated');
        return redirect('subcategory_view'.'/'.$category_id->parent_id);
    }else{
        return back()->with('error','something went worng!');
    }
   }
   public function subadd(Request $request,$id){

        $subcategories=Category::where('id','=',$id)->get();

        return view('backend.subcategory.subadd',compact('subcategories'));
    }
    public function subcategory_create(Request $request){

       if($request->category){
            $subcategory = $request->title;
            $subcategory_photo = $request->subcat_photo;
            $category = Category::where('id','=',$request->category)->first();
            foreach($subcategory as $key => $vals){
              if(!empty($vals)){

                $slug = Str::slug($vals);
                $slug_count = Category::where('slug', $slug)->count();
                if ($slug_count > 0) {
                    $slug .= time() . '-' . $slug;
                }
                if(!empty($subcategory_photo[$key])){
                    $photo = $subcategory_photo[$key];
                }
                else{
                    $photo = '';
                }

                $data['slug'] = $slug;
                $data['title'] = $subcategory[$key];
                $data['photo'] = $photo;
                $data['headerorder'] = $category->headerorder;
                $data['homeorder'] = $category->homeorder;
                $data['home'] = $category->home;
                $data['category'] = $category->category;
                $data['offers'] = $category->offers;
                $data['header'] = 'active';
                $data['is_parent'] = 1;
                $data['parent_id'] = $request->category;
                $data['status'] = "Active";

                $status = Category::create($data);
              }

            }

       }
             if ($status) {
                Session::put('success', 'Successfully updated Sub Category');
                return redirect()->route('category.index');

            } else {
                return back()->with('error', 'something went worng!');
            }

    }
}
