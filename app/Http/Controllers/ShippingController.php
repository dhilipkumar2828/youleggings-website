<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Shipping;

use Illuminate\Support\Facades\DB;

use Illuminate\Support\Facades\Http;

class ShippingController extends Controller

{

    /**

     * Display a listing of the resource.

     *

     * @return \Illuminate\Http\Response

     */

    public function index()

    {

       // $shipping=Shipping::orderBy('id','DESC')->get();

        return view('frontend.shipping_policy')->with('shippings',$shipping);

    }

    public function shippingstatus(Request $request)

    {

    //    dd($request->all());

    if($request->mode=='true'){

        DB::table('shippings')->where('id',$request->id)->update(['status'=>'active']);

    }

    else{

        DB::table('shippings')->where('id',$request->id)->update(['status'=>'inactive']);

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

    /**

     * Check Shipping service is available at a given pincode

     *

     * @param  \Illuminate\Http\Request $request of pincode, st(Short Code of State), date

     * @return \Illuminate\Http\Response

     */

    public function pincodeServiceability(Request $request)

    {

        //

        $url = 'https://staging-express.delhivery.com/c/api/pin-codes/json/?filter_codes='.$request->pincode.'&dt='.$request->date.'&st='.$request->st; ///*.$request->date.*/

        $response = Http::acceptJson()->withToken('57f97905d9d72afb9ce409c83ab0d38931e3e107')->get($url);

        // $response = Http::withHeaders([

        //     'Authorization'=>'Token 57f97905d9d72afb9ce409c83ab0d38931e3e107',

        //     'Content-Type'=>'application/json'

        // ])->get($url);

        // echo '<pre>';

        // var_dump($response->json());

        $aResp = $response->json();

        if(!empty($aResp) && !empty($aResp['delivery_codes'])) {

            // echo $aResp['delivery_codes'][0]['postal_code']['pin'];

            // exit;

            if($aResp['delivery_codes'][0]['postal_code']['pin'] != '' && $aResp['delivery_codes'][0]['postal_code']['cod'] == 'Y') {

                return json_encode(array(

                    'message' => 'Shipping service is Available',

                    'cod' => $aResp['delivery_codes'][0]['postal_code']['cod'],

                    'max_amount' => $aResp['delivery_codes'][0]['postal_code']['max_amount'],

                    'pre_paid' => $aResp['delivery_codes'][0]['postal_code']['pre_paid'],

                    'cash' => $aResp['delivery_codes'][0]['postal_code']['cash']

                ));

            } else {

                return json_encode(array(

                    'message' => 'Shipping service is not Available',

                    'cod' => 'N',

                    'max_amount' => '0',

                    'pre_paid' => 'N',

                    'cash' => 'N'

                ));

            }

        } else {

            return json_encode(array(

                'message' => 'Shipping service is not Available',

                'cod' => 'N',

                'max_amount' => '0',

                'pre_paid' => 'N',

                'cash' => 'N'

            ));

        }

    }

}
