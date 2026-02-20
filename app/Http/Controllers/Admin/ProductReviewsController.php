<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

use App\Models\ProductReviews;

use Auth;

use Illuminate\Support\Facades\Session;

use DB;

class ProductReviewsController extends Controller

{

    function __construct()

    {

         $this->middleware('permission:product_review-view', ['only' => ['index','store']]);

    }

    /**

     * Display a listing of the resource.

     *

     * @return \Illuminate\Http\Response

     */

    public function index()

    {

        //

    }

    public function productReview(Request $request){

        $review = Session::get('product_review',[]);

        $aNewReviewData = array(

            'product_id' => $request->product_id,

            'rate' => $request->rate,

            'review' => $request->review,

            'name' => $request->name,

            'phone' => $request->phone_number,

            'email' => $request->email

        );

        if(auth()->guard('users')->user()){

            $user=Auth::guard('users')->user();

            $duplicatecheck=ProductReviews::where('status','accept')->where('customer_id',$user->id)->where('product_id',$request->product_id)->get();

            if(count($duplicatecheck) <=0){

                $review=new ProductReviews;

                $review->customer_id=auth()->guard('users')->user()->id;

                $review->product_id=$request->product_id;

                $review->rate=$request->rate;

                $review->review=$request->review;

                $review->name=$request->name;

                $review->phone_number=$request->phone_number;

                $review->email=$request->email;

                $review->save();

            }else{

                ProductReviews::where('status','accept')->where('customer_id',$user->id)->where('product_id',$request->product_id)->update(['name'=>$request->name,'review'=>$request->review,'email'=>$request->email,'phone_number'=>$request->phone_number,'rate'=>$request->rate]);

            }

                $response['success']=true;

         $count_reviews=ProductReviews::where('status','accept')->where('product_id',$request->product_id)->orderBy('id','desc')->get();

        $reviews=ProductReviews::where('status','accept')->where('product_id',$request->product_id)->orderBy('id','desc')->limit(3)->get();

        $rendered_reviews = view('frontend.review', ['product_review'=>$reviews,'count_reviews'=>$count_reviews])->render();

        $response['rendered_reviews']=$rendered_reviews;

        }else{

            Session::put('product_review',$aNewReviewData);

            $response['success']=false;

        }

        return $response;

    }

    public function viewmore(Request $request){

        $reviews=ProductReviews::where('status','accept')->orderBy('id','desc')->where('product_id',$request->id)->limit($request->limit)->get();

        $rendered_reviews = view('frontend.review', ['reviews'=>$reviews])->render();

        $response['rendered_reviews']=$rendered_reviews;

        return $response;

    }

    /**

     * Show the form for creating a new resource.

     *

     * @return \Illuminate\Http\Response

     */

    public function create()

    {

        //

    }

    /**

     * Store a newly created resource in storage.

     *

     * @param  \Illuminate\Http\Request  $request

     * @return \Illuminate\Http\Response

     */

    public function store(Request $request)

    {

        //

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

        //

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

        //

    }

    /**

     * Remove the specified resource from storage.

     *

     * @param  int  $id

     * @return \Illuminate\Http\Response

     */

    public function destroy($id)

    {

        //

    }

}
