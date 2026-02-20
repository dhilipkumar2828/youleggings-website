<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use App\Models\PurchaseOrder;

use App\Models\Purchase;

use App\Models\PurchaseProduct;

use App\Models\Product;

use App\Models\VendorItem;

use App\Models\VendorItemAttribute;

use App\Models\Coupon;

use App\Models\Vendor;

use App\Models\Quotation;

use App\Models\Invoice;

use App\Models\ProductAttribute;

use App\Models\Inventory;

use App\Models\InventoryProduct;

use App\Models\InventoryLoss;

use App\Models\InventoryHistory;

use App\Models\Warehouse;

use App\Models\InventoryLossProduct;

use Illuminate\Support\Facades\Session;

use Illuminate\Http\Request;

class InventoryController extends Controller

{

      function __construct()

    {

        //  $this->middleware('permission:Inventory List|Inventory Receiving Voucher Create|Inventory Receiving Voucher View|Inventory Receiving Voucher Delete', ['only' => ['index','store']]);

        //  $this->middleware('permission:Inventory Receiving Voucher Create', ['only' => ['delivery_docket','store']]);

        //  $this->middleware('permission:Inventory Receiving Voucher View', ['only' => ['edit','update']]);

        //  $this->middleware('permission:Inventory Receiving Voucher Delete', ['only' => ['destroy']]);

        //  $this->middleware('permission:Inventory History List', ['only' => ['inventory_history']]);

        //  $this->middleware('permission:Inventory Loss Adjustment List', ['only' => ['lossadjust']]);

    }

    /**

     * Display a listing of the resource.

     *

     * @return \Illuminate\Http\Response

     */

    public function index()

    {

        $inventory=Inventory::get();

        return view('backend.inventory.inventory-receiving-voucher',compact('inventory'));

    }

    public function lossadjust()

    {

        $inventory=InventoryLoss::join('inventory','inventory.id','=','inventoryloss.inventory_id')->get(['inventory.delivery_number','inventoryloss.*']);

        return view('backend.inventory.loss-adjust',compact('inventory'));

    }

    public function delivery_docket()

    {

        return view('backend.inventory.delivery-docket');

    }

    public function inventory_history()

    {

        $inventory=InventoryHistory::join('inventory','inventory.id','=','inventoryhistroy.inventory_id')->orderBy('inventoryhistroy.id','DESC')->get(['inventoryhistroy.*','inventory.*']);

        return view('backend.inventory.inventory-histroy',compact('inventory'));

    }

    public function delivery_docket_details(Request $request)

    {

        $purchaseorder=PurchaseOrder::find($request->id);

        if($purchaseorder){

            $purchase_request_id=$purchaseorder->purchase_request_id;

            $purchase=Purchase::find($purchase_request_id);

            $purchaseproduct=PurchaseProduct::where('purchase_request_id',$purchase_request_id)->get();

            $gstvalue=PurchaseProduct::where(['purchase_request_id'=>$purchase_request_id])->groupBy('tax_rate')->get();

            $invoice=Invoice::where('purchase_order_id',$request->id)->get();

        return response()->json(['status'=>true,'invoice'=>$invoice,'purchase'=>$purchase,'purchasproduct'=>$purchaseproduct,'gstvalue'=>$gstvalue,'msg'=>'']);

        }

        else{

            return response()->json(['status'=>false,'data'=>null,'msg'=>'Purchase Order not found']);

        }

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

      //  dd($request->all());

        $data=$request->all();

        //return $data;

     // dd(json_decode($data['productdata'][0]));

        $sdata=[

            "id"=>NULL,

            "delivery_number"=>$request->get('delivery_number'),

            "purchase_order_id"=>$request->get('purchase_order'),

            "vendor_id"=>$request->get('vendor_name'),

            "buyer"=> $request->get('buyer'),

            "deliverer"=>$request->get('deliverer'),

            "note"=>$request->get('inventory_note'),

            "accounting_date"=>$request->get('accounting_date'),

            "voucher_date"=>$request->get('voucher_date'),

            "warehouse"=>$request->get('warehourse'),

            "invoice_id"=>$request->get('invoice_id'),

            "expiry_date"=>$request->get('expiry_date'),

            "total_tax"=>$request->get('total_tax'),

            "value_of_inventory"=>$request->get('value_of_inventory'),

            "total_amount"=>$request->get('total_amount'),

            "status"=>'active'

        ];

        $status=Inventory::create($sdata);

        $id=$status->id;

        $lossdata=[

            "inventory_id"=>$id,

            "warehouse"=>$request->get('warehourse'),

            "status"=>'Open'

        ];

       if(in_array('disapproved',$data['productcheck'])){

        InventoryLoss::create($lossdata);

       }

        for($i=0;$i<count($data['productcheck']);$i++){

        $productdata=json_decode($data['productdata'][$i],true);

        $upt1=ProductAttribute::where(["id"=>$productdata[0]['attribute_id']])->get();

        $openstock=$upt1[0]['stock'];

        $productprice=$upt1[0]['original_price'];

        $data1=[

            "id"=>NULL,

            "inventory_id"=>@$id,

            "vendor_item_id"=>@$productdata[0]['vendor_item_id'],

            "product_id"=>@$productdata[0]['product_id'],

            "product_name"=>$productdata[0]['product_name'],

            "attribute_id"=>$productdata[0]['attribute_id'],

            "attribute_name"=>$productdata[0]['attribute_name'],

            "attribute_value"=>$productdata[0]['attribute_value'],

            "open_stock"=> $openstock,

            "quantity"=>$openstock+$productdata[0]['quantity'],

            "product_price"=>$productprice,

            "buying_price"=>$productdata[0]['buying_price'],

            "product_status"=>$data['productcheck'][$i]

        ];

        $warehouse=Warehouse::where(["id"=>$request->get('warehourse')])->get();

        $histroy=[

            "id"=>NULL,

            "inventory_id"=>@$id,

            "product_name"=>$productdata[0]['product_name'],

            "attribute_name"=>$productdata[0]['attribute_name'],

            "attribute_value"=>$productdata[0]['attribute_value'],

            "warehouse_code"=>$warehouse[0]['warehouse_code'],

            "warehouse_name"=>$warehouse[0]['warehouse_name'],

            "voucher_date"=>$request->get('voucher_date'),

            "open_stock"=> $openstock,

            "quantity"=>$openstock+$productdata[0]['quantity'],

            "expiry_date"=>$request->get('expiry_date'),

            "product_price"=>$productprice,

            "buying_price"=>$productdata[0]['buying_price']

        ];

       // dd($data1);

        //print_r($data1);

        if($data['productcheck'][$i] == 'approved'){

        $status1=InventoryProduct::create($data1);

        InventoryHistory::create($histroy);

        $upt=ProductAttribute::where(["id"=>$productdata[0]['attribute_id']])->get();

        $stock=$upt[0]['stock']+$productdata[0]['quantity'];

        ProductAttribute::where(["id"=>$productdata[0]['attribute_id']])->update(['stock'=>$stock]);

        }

        else{

        InventoryLossProduct::create($data1);

        }

    }

        if($status1){

            Session::put('success','Inventory Receiving Voucher create successfully');

            return redirect()->route('inventory.index');

        }

        else{

            return back()->with('error','Data not found');

        }

    }

    /**

     * Display the specified resource.

     *

     * @param  \App\Models\Inventory  $inventory

     * @return \Illuminate\Http\Response

     */

    public function show($id)

    {

        $inventory=Inventory::find($id);

        $inventoryproduct=InventoryProduct::where('inventory_id',$id)->get();

        return view('backend.inventory.inventory-receiving-voucher-view',compact('inventory','inventoryproduct'));

    }

    public function view($id)

    {

        $inventory=InventoryLoss::join('inventory','inventory.id','=','inventoryloss.inventory_id')->find($id);

        $inventoryproduct=InventoryLossProduct::where('inventory_id',$inventory->id)->get();

        return view('backend.inventory.loss-adjust-view',compact('inventory','inventoryproduct'));

    }

    /**

     * Show the form for editing the specified resource.

     *

     * @param  \App\Models\Inventory  $inventory

     * @return \Illuminate\Http\Response

     */

    public function edit($id)

    {

        $inventory=InventoryLoss::join('inventory','inventory.id','=','inventoryloss.inventory_id')->find($id);

        $inventoryproduct=InventoryLossProduct::where(['inventory_id'=>$inventory->id,'product_status'=>'disapproved'])->get();

        return view('backend.inventory.loss-adjust-update',compact('inventory','inventoryproduct'));

    }

    /**

     * Update the specified resource in storage.

     *

     * @param  \Illuminate\Http\Request  $request

     * @param  \App\Models\Inventory  $inventory

     * @return \Illuminate\Http\Response

     */

    public function update(Request $request, $uid)

    {

        $data=$request->all();

        $sdata=[

            "adjust_date"=>$request->get('adjust_date'),

            "adjust_reason"=>$request->get('adjust_reason'),

           ];

        $status=InventoryLoss::where('id',$uid)->update($sdata);

        for($i=0;$i<count($data['productcheck']);$i++){

        $productdata=json_decode($data['productdata'][$i],true);

      //  dd($productdata);

       // dd($data1);

        //print_r($data1);

        $upt1=ProductAttribute::where(["id"=>$productdata[0]['attribute_id']])->get();

        $openstock=$upt1[0]['stock'];

        $warehouse=Warehouse::where(["id"=>$request->get('warehourse')])->get();

        $histroy=[

            "id"=>NULL,

            "inventory_id"=>@$productdata[0]['inventory_id'],

            "product_name"=>$productdata[0]['product_name'],

            "attribute_name"=>$productdata[0]['attribute_name'],

            "attribute_value"=>$productdata[0]['attribute_value'],

            "warehouse_code"=>$warehouse[0]['warehouse_code'],

            "warehouse_name"=>$warehouse[0]['warehouse_name'],

            "voucher_date"=>$request->get('voucher_date'),

            "open_stock"=> $openstock,

            "quantity"=>$productdata[0]['quantity'],

            "expiry_date"=>$request->get('expiry_date'),

        ];

        if($data['productcheck'][$i] == 'approved'){

        $status1=InventoryLossProduct::where(['id'=>$productdata[0]['id'],'inventory_id'=>$request->get('inventory_id')])->update(['product_status'=>'approved']);

        InventoryHistory::create($histroy);

        $upt=ProductAttribute::where(["id"=>$productdata[0]['attribute_id']])->get();

        $stock=$upt[0]['stock']+$productdata[0]['quantity'];

        ProductAttribute::where(["id"=>$productdata[0]['attribute_id']])->update(['stock'=>$stock]);

        }

    }

    if(!in_array('disapproved',$data['productcheck'])){

        InventoryLoss::where('id',$uid)->update(['status'=>'Closed']);

    }

        if($status1){

            Session::put('success','Inventory Loss Adjustment Update successfully');

            return redirect()->route('inventory.loss-adjust');

        }

        else{

            return back()->with('error','Data not found');

        }

    }

    /**

     * Remove the specified resource from storage.

     *

     * @param  \App\Models\Inventory  $inventory

     * @return \Illuminate\Http\Response

     */

    public function destroy($id)

    {

        $inventory=Inventory::find($id);

        if($inventory){

            foreach(InventoryProduct::where(['inventory_id'=>$id])->get() as $data){

                $upt=ProductAttribute::where(["id"=>$data['attribute_id']])->get();

                $stock=$upt[0]['stock']-$data['quantity'];

                ProductAttribute::where(["id"=>$data['attribute_id']])->update(['stock'=>$stock]);

            }

            InventoryProduct::where(['inventory_id'=>$id])->delete();

            $status=$inventory->delete();

            if($status){

                Session::put('error','Inventry Receiving Voucher successfully deleted');

                return redirect()->route('inventory.index');

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
