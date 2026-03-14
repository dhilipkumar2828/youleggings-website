<?php

namespace App\Http\Controllers\Admin;

use App\Models\Product;
use App\Models\Coupon;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Auth;
class CouponController extends Controller
{
    function __construct()
    {
         $this->middleware('permission:coupon-view|coupon-add|coupon-edit|coupon-delete', ['only' => ['index','store']]);
         $this->middleware('permission:coupon-add', ['only' => ['create','store']]);
         $this->middleware('permission:coupon-edit', ['only' => ['edit','update']]);
         $this->middleware('permission:coupon-delete', ['only' => ['destroy']]);
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
        // $user=(Auth::user()->roles[0]->id == 1) ?['1'] : ['1',$this->userid];

        $product=Coupon::orderBy('id','DESC')->get();
        return view('backend.coupon.index',compact('product'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */

     public function create()
    {

        date_default_timezone_set('Asia/Kolkata');
        $currTime = date('Y-m-d H:i:s');

        // Fetch all product IDs from the `coupon` table where `product_id` is not null
        $excludedProductIds = DB::table('coupon')
            ->whereNotNull('product_id')
            ->where('end_date', '>',  $currTime )
            ->orWhere('offer_details','=','1')
            ->pluck('product_id')  // Get the product_ids
            ->flatMap(function ($productIds) {
                // Split comma-separated product IDs into an array
                return explode(',', $productIds);
            })
            ->unique()  // Remove duplicate IDs
            ->toArray();

        // Fetch active products excluding the selected ones
        $product = Product::where('status', '=', 'active')
            // ->whereNotIn('id', $excludedProductIds)
            ->get();

        $category = \App\Models\Category::where('status', 'active')->where('parent_id', null)->get();
        // Pass the filtered products to the view
        return view('backend.coupon.add', compact('product', 'category'));
    }

       public function create123()
    {

        //$product=Product::get();
        //   $product=Product::all();
        $product = Product::where('status', 'active')
        ->whereNotIn('id', function ($query) {
            $query->select('product_id')->from('coupon')->whereNotNull('product_id');
        })
        ->get();

        return view('backend.coupon.add',compact('product'));;

    }

    public function status(Request $request)
    {
    //    dd($request->all());
    if($request->mode=='true'){
        DB::table('coupon')->where('id',$request->id)->update(['Status'=>'active']);
        $coupon_status="active";
    }
    else{
        DB::table('coupon')->where('id',$request->id)->update(['Status'=>'inactive']);
        $coupon_status="inactive";

    }
    return response()->json(['msg'=>'Successfully update status','status'=>true]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

             public function store(Request $request)
        {
            $this->validate($request, [
                'coupon_name' => 'string|required',
                'coupon_code' => 'required|string|unique:coupon,coupon_code',
                //'start_date'=>'required',
                //'end_date'=>'required',
                // 'value'=>'nullable|numeric|required',
                'Status' => 'nullable|in:active,inactive',
            ], [
                'coupon_code.unique' => 'This coupon code has already been used.',
            ]);

            $data = $request->all();

            $start_date = $request->start_date;
            $end_date = $request->end_date;

            $data['discount_type'] = "percentage";
            $data['start_date'] = str_replace("T", " ", $start_date) . ":00";
            $data['end_date'] = str_replace("T", " ", $end_date) . ":00";

            $data['offeramountabove'] = $request->offeramountabove;
            $data['flatofferamount'] = $request->flatofferamount;
            $data['offer_details'] = $request->offer_details;

            // Check if products are selected, if not set default to 0
            $productIds = !empty($request->product_id) ? implode(",", $request->product_id) : '0';
            $data['product_id'] = $productIds;

            $status = Coupon::create($data);
            if ($status) {
                Session::put('success', 'Coupon created successfully');
                return redirect()->route('coupon.index');
            } else {
                return back()->with('error', 'Data not found');
            }
        }
       public function store1233(Request $request)
     {
         $this->validate($request, [
             'coupon_name' => 'string|required',
             'coupon_code' => 'required|string|unique:coupon,coupon_code',
             'product_id' => 'required|array', // Ensure an array of product IDs is passed
             'product_id.*' => 'exists:products,id', // Validate each product ID
             'Status' => 'nullable|in:active,inactive',
         ], [
             'coupon_code.unique' => 'This coupon code has already been used.',
             'product_id.required' => 'Please select at least one product.',
         ]);

         $start_date = $request->start_date;
         $end_date = $request->end_date;

         // Prepare common data
         $data = $request->except('product_id');
         $data['discount_type'] = "percentage";
         $data['start_date'] = str_replace("T", " ", $start_date) . ":00";
         $data['end_date'] = str_replace("T", " ", $end_date) . ":00";

         // Convert selected product IDs to a string (comma-separated or JSON)
         $productIds = implode(",", $request->product_id); // For CSV
         // $productIds = json_encode($request->product_id); // Use this line if you want to store them as a JSON array.

         $data['product_id'] = $productIds;

         // Create a single coupon entry
         Coupon::create($data);

         Session::put('success', 'Coupons created successfully');
         return redirect()->route('coupon.index');
     }

  public function checkCouponcode(Request $request)
{
    $coupon_code = $request->input('coupon_code');

    // Check if the pincode exists in the database
    $exists = \DB::table('coupon')->where('coupon_code', $coupon_code)->exists();

    // Return the result as JSON
    return response()->json([
        'exists' => $exists
    ]);
}

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $coupon=Coupon::find($id);
        if($coupon){
            return view('backend.coupon.edit',compact('coupon'));
        }
        else{
            return back()->with('error','Data not  found');
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {

        $coupon=Coupon::find($id);
        // $product=Product::all();

           // Fetch active products excluding the selected ones
        $product = Product::where('status', '=', 'active')
            // ->whereNotIn('id', $excludedProductIds)
            ->get();
       // $product=Product::get();
        $category = \App\Models\Category::where('status', 'active')->where('parent_id', null)->get();
        if($coupon){
            return view('backend.coupon.edit',compact('coupon','product','category'));
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
    $coupon = Coupon::find($id);
    if ($coupon) {
        $this->validate($request, [
            'coupon_name' => 'string|required',
            'coupon_code' => 'string|required',
            //'start_date'=>'required',
            //'end_date'=>'required',
            //'value'=>'nullable|numeric|required',
            'Status' => 'nullable|in:active,inactive',
        ]);

        $data = $request->all();
        $data['discount_type'] = "percentage";

        $start_date = $request->start_date;
        $end_date = $request->end_date;

        $data['start_date'] = str_replace("T", " ", $start_date) . ":00";
        $data['end_date'] = str_replace("T", " ", $end_date) . ":00";

        $data['offeramountabove']= $request->offeramountabove;
        $data['flatofferamount']= $request->flatofferamount;
        $data['offer_details']= $request->offer_details;

  $productIds = !empty($request->product_id) ? implode(",", $request->product_id) : '0';
            $data['product_id'] = $productIds;

        // Update the coupon
        $status = $coupon->fill($data)->save();

        if ($status) {
            Session::put('success', 'Coupon Successfully Updated');
            return redirect()->route('coupon.index');
        } else {
            return back()->with('error', 'Something went wrong!');
        }
    } else {
        return back()->with('error', 'Data not found');
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
        $coupon=Coupon::find($id);
        if($coupon){
            $status=$coupon->delete();
            if($status){
                Session::put('error','Coupon successfully deleted');
                return redirect()->route('coupon.index');
            }
            else{
                return back()->with('success','Data not found');
            }
        }
        else{
            return back()->with('error','Data not  found');
        }
    }
    public function coupon_show(Request $request)
    {
        $coupon = Coupon::find($request->id);
        if ($coupon) {
            return response()->json([
                'coupon_name' => $coupon->coupon_name,
                'minimum_order_amount' => $coupon->minimum_order_amount,
                'coupon_code' => $coupon->coupon_code,
                'value' => $coupon->value,
                'start_date' => $coupon->start_date,
                'end_date' => $coupon->end_date,
                'discount_type' => $coupon->discount_type,
                'status' => $coupon->Status
            ]);
        }
        return response()->json(['error' => 'Coupon not found'], 404);
    }
}
