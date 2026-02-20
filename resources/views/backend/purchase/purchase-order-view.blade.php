@extends('backend.layouts.master')

@section('content')
    <div class="page-content-wrapper ">

        <div class="container-fluid">

            <div class="row">

                <div class="col-sm-12">

                    <div class="float-right page-breadcrumb">

                        <ol class="breadcrumb">

                            <li class="breadcrumb-item"><a href="#"> Purchase</a></li>

                            <li class="breadcrumb-item active">Purchase Order</li>

                        </ol>

                    </div>

                    <h5 class="page-title">Purchase Order</h5>

                </div>

            </div>

            <div class="card m-b-30 card-body">

                <h4 class="card-title font-20 mt-0">View Purchase Order</h4>

                <a href="{{ route('purchaseorder.index') }}" id="add-btn" style="color: #ffffff;"><i
                        class="fa fa-angle-left" aria-hidden="true"></i> Back</a>

            </div>

            <div class="row">

                <div class="col-12">

                    <div class="card m-b-30">

                        <div class="card-body">

                            <form method="post" action="{{ route('purchaseorder.update', $purchaseorder->id) }}">

                                @csrf

                                @method('patch')

                                <div class="row">

                                    <div class="col-md-6">

                                        <div class="form-group row">

                                            <label for="example-text-input" class="col-sm-4 col-form-label">Purchase Order
                                                Code </label>

                                            <div class="col-sm-8">

                                                <input class="form-control" type="text" placeholder="Enter"
                                                    value="{{ $purchaseorder->purchase_order_id }}" readonly
                                                    id="example-text-input">

                                                <input class="form-control" type="hidden" name="purchase_order_id"
                                                    placeholder="Enter" value="{{ $purchaseorder->id }}" readonly
                                                    id="example-text-input">

                                            </div>

                                        </div>

                                    </div>

                                    <div class="col-md-6">

                                        <div class="form-group row">

                                            <label for="example-text-input" class="col-sm-4 col-form-label">Purchase Order
                                                Date </label>

                                            <div class="col-sm-8">

                                                <input class="form-control" type="text" placeholder="Enter"
                                                    value="{{ $purchaseorder->order_date }}" readonly
                                                    id="example-text-input">

                                            </div>

                                        </div>

                                    </div>

                                    <div class="col-md-6">

                                        <div class="form-group row">

                                            <label for="example-text-input" class="col-sm-4 col-form-label">Purchase
                                                Delivery Date </label>

                                            <div class="col-sm-8">

                                                <input class="form-control" type="date" placeholder="Enter" required
                                                    name="delivery_date"
                                                    value="{{ old('delivery_date') }}{{ $purchaseorder->delivery_date }}"
                                                    id="example-text-input">

                                            </div>

                                        </div>

                                    </div>

                                    <div class="col-md-6">

                                        <div class="form-group row">

                                            <label for="example-text-input" class="col-sm-4 col-form-label">Purchase Request
                                                Name</label>

                                            <div class="col-sm-8">

                                                <input class="form-control" type="text" placeholder="Enter " readonly
                                                    value="{{ $purchase->purchase_request_name }}"
                                                    name="purchase_request_name" id="example-text-input">

                                            </div>

                                        </div>

                                    </div>

                                    <div class="col-md-6">

                                        <div class="form-group row">

                                            <label for="example-text-input" class="col-sm-4 col-form-label">Vendor ID
                                            </label>

                                            <div class="col-sm-8">

                                                <input class="form-control" type="text" placeholder="Enter"
                                                    value="{{ $purchase->vendor_items_id }}" readonly
                                                    id="example-text-input">

                                            </div>

                                        </div>

                                    </div>

                                    <div class="col-md-6">

                                        <div class="form-group row">

                                            <label for="example-text-input" class="col-sm-4 col-form-label">Vendor
                                                Name</label>

                                            <div class="col-sm-8">

                                                <input class="form-control" type="hidden" placeholder="Enter "
                                                    value="{{ $purchase->vendor_id }}" name="vendor"
                                                    id="example-text-input">

                                                <input class="form-control" readonly type="text" placeholder="Enter "
                                                    value="{{ $purchase->vendor_name }}" id="example-text-input">

                                            </div>

                                        </div>

                                    </div>

                                    @php

                                        $ar = [];

                                        foreach ($purchaseproduct as $pd) {
                                            array_push($ar, $pd->product_id);
                                        }

                                    @endphp

                                    <div class="col-md-6">

                                        <div class="form-group row">

                                            <label for="example-text-input"
                                                class="col-sm-4 col-form-label">Products</label>

                                            <div class="col-sm-8">

                                                <select class="js-example-basic-single addproduct" id="vendoritems"
                                                    placeholder="Select Products" style="width:100%;"
                                                    multiple="multiple">

                                                    @foreach (\App\Models\VendorItem::where('vendoritem.vendor_id', $purchase->vendor_id)->join('products', 'products.id', '=', 'vendoritem.product_id')->get(['vendoritem.*', 'products.title']) as $key => $value)
                                                        @if (in_array($value->product_id, $ar))
                                                            <option
                                                                value="{{ $value->id . '|' . $value->product_id . '|' . $value->title . '|' . $value->vendor_item_id }}"
                                                                locked="locked" selected>{{ $value->title }}</option>
                                                        @else
                                                            <option
                                                                value="{{ $value->id . '|' . $value->product_id . '|' . $value->title . '|' . $value->vendor_item_id }}">
                                                                {{ $value->title }}</option>
                                                        @endif
                                                    @endforeach

                                                </select>

                                            </div>

                                        </div>

                                    </div>

                                    <div class=" col-md-12 product">

                                        @php

                                            $arr = [];

                                            $c = 0;

                                        @endphp

                                        @foreach ($purchaseproduct as $k => $item)
                                            @php

                                                array_push($arr, $item['product_id']);

                                                $c = $k;

                                            @endphp

                                            <div class="row " id="child{{ $k }}">

                                                <div class="col-md-8">

                                                    <div class="form-group row">

                                                        <label for="example-text-input"
                                                            class="col-sm-4 col-form-label">Product Name</label>

                                                        <div class="col-sm-8"><input type="hidden"
                                                                value="{{ $item->product_id }}" name="product_id[]"
                                                                id="product_id{{ $item->product_id }}">

                                                            <input type="hidden" value="{{ $item->vendor_items_id }}"
                                                                name="vendor_items_id"
                                                                id="vendor_items_id{{ $item->product_id }}">

                                                            <input type="hidden" value="{{ $item->vendor_item_id }}"
                                                                name="vendor_item_id[]"
                                                                id="vendor_item_id{{ $item->product_id }}">

                                                            <input class="form-control" type="text"
                                                                name="product_name[]"
                                                                id="product_name{{ $item->product_id }}" readonly=""
                                                                value="{{ $item->product_name }}" placeholder="Enter">

                                                        </div>

                                                    </div>

                                                </div>

                                                <div class="col-md-2">

                                                    <div class="form-group row">

                                                        <label for="example-text-input"
                                                            class="col-sm-4 col-form-label">Tax Rate</label>

                                                        <input class="form-control" type="text" readonly=""
                                                            value="{{ \App\Models\Product::find($item->product_id)['tax_value'] }}"
                                                            placeholder="Enter">

                                                    </div>

                                                </div>

                                                <div class="col-md-12"><label for="example-text-input"
                                                        class="col-form-label"><b>Product Attributes</b></label></div>

                                                <div class="col-md-12 attribute1" style="background-color: #f9f9f9;">
                                                </div>

                                            </div>

                                            <b>

                                                @foreach (\App\Models\PurchaseProduct::where(['purchase_request_id' => $item->purchase_request_id, 'product_id' => $item->product_id])->get() as $k1 => $item1)
                                                    <div class="row " id="attrchild0">

                                                        <div class="col-md-3">

                                                            <div class="form-group row">

                                                                <label for="example-text-input"
                                                                    class="col-sm-6 col-form-label">Attribute Type</label>

                                                                <div class="col-sm-8"><input class="form-control"
                                                                        type="hidden"
                                                                        name="attribute_id[{{ $item1->product_id }}][]"
                                                                        readonly value="{{ $item1->attribute_id }}"
                                                                        placeholder="Enter" id="attribute_id0-6"><input
                                                                        class="form-control" type="text"
                                                                        readonly="" disabled="true"
                                                                        name="attribute_name[{{ $item1->product_id }}][]"
                                                                        value="{{ $item1->attribute_name }}"
                                                                        placeholder="Enter" id="attribute_name0-6"></div>

                                                            </div>

                                                        </div>

                                                        <div class="col-md-2">

                                                            <div class="form-group row">

                                                                <label for="example-text-input"
                                                                    class="col-sm-12 col-form-label">Attribute
                                                                    Value</label>

                                                                <div class="col-sm-10"><input class="form-control"
                                                                        type="text" readonly=""
                                                                        name="attribute_value[{{ $item1->product_id }}][]"
                                                                        disabled="true"
                                                                        value="{{ $item1->attribute_value }}"
                                                                        placeholder="Enter"
                                                                        id="attribute_value{{ $k1 }}-{{ $item1->product_id }}">
                                                                </div>

                                                            </div>

                                                        </div>

                                                        <div class="col-md-2">

                                                            <div class="form-group row">

                                                                <label for="example-text-input"
                                                                    class="col-sm-12 col-form-label">Quantity</label>

                                                                <div class="col-sm-10"><input class="form-control"
                                                                        type="text"
                                                                        name="qty[{{ $item1->product_id }}][]"
                                                                        value="{{ $item1->quantity }}" readonly
                                                                        placeholder="Enter"
                                                                        id="qty{{ $k1 }}-{{ $item1->product_id }}">
                                                                </div>

                                                            </div>

                                                        </div>

                                                        <div class="col-md-2">

                                                            <div class="form-group row">

                                                                <label for="example-text-input"
                                                                    class="col-sm-12 col-form-label">Price</label>

                                                                <div class="col-sm-10"><input class="form-control"
                                                                        type="text"
                                                                        name="buying_price[{{ $item1->product_id }}][]"
                                                                        value="{{ $item1->buying_price }}" readonly
                                                                        placeholder="Enter"
                                                                        id="buying_price{{ $k1 }}-{{ $item1->product_id }}">
                                                                </div>

                                                            </div>

                                                        </div>

                                                        <div class="col-md-2">

                                                            <div class="form-group row">

                                                                <label for="example-text-input"
                                                                    class="col-sm-12 col-form-label">Status</label>

                                                                <div class="col-sm-10"><span
                                                                        class="badge badge-success">Active</span></div>

                                                                <div class="col-sm-0"><input type="checkbox"
                                                                        onclick="all1(this);"
                                                                        data-id="{{ $k1 }}|{{ $item1->product_id }}"
                                                                        value="yes" disabled checked
                                                                        placeholder="Enter" readonly id="all"></div>

                                                            </div>

                                                        </div>

                                                    </div>
                                                @endforeach

                                            </b>
                                        @endforeach

                                        <div class="row " id="attrchild0">

                                            <div class="col-md-7"></div>

                                            <div class="col-md-2">

                                                <div class="form-group row">

                                                    <label for="example-text-input" class="col-sm-12 col-form-label">Total
                                                        Price :
                                                        {{ \App\Models\PurchaseProduct::where(['purchase_request_id' => $item->purchase_request_id])->sum('buying_price') }}</label>

                                                </div>

                                            </div>

                                        </div>

                                    </div>

                                    <div class="col-md-12">

                                        <div class="form-group row">

                                            <label for="example-text-input" class="col-sm-4 col-form-label">Purchase
                                                Description </label>

                                            <div class="col-sm-8">

                                                <textarea class="form-control" placeholder="Purchase Description" name="description"
                                                    value="{{ old('description') }}" id="example-text-input">{{ old('description') }}{{ $purchaseorder->description }}</textarea>

                                            </div>

                                        </div>

                                    </div>

                                    <div class="col-md-12 d-flex">

                                        <button class="btn btn-primary" type="submit">Update</button>&nbsp;

                                        <button class="btn btn-secondary " type="reset">Cancel</button>

                                    </div>

                                </div>

                            </form>

                        </div>

                    </div>

                </div> <!-- end col -->

            </div> <!-- end row -->

        </div><!-- container fluid -->

    </div> <!-- Page content Wrapper -->

    </div> <!-- content -->

    </div>

    <!-- End Right content here -->

    </div>

    <!-- END wrapper -->
@endsection

@section('scripts')
    <script>
        $(document).ready(function() {

            $('.js-example-basic-single').select2({

                    // maximumSelectionLength: 4,

                    placeholder: "Select Products",

                    templateSelection: function(tag, container) {

                        // here we are finding option element of tag and

                        // if it has property 'locked' we will add class 'locked-tag'

                        // to be able to style element in select

                        var $option = $('.select2 option[value="' + tag.id + '"]');

                        if ($option.attr('locked')) {

                            $(container).addClass('locked-tag');

                            tag.locked = true;

                        }

                        return tag.text;

                    },

                })

                .on('select2:unselecting', function(e) {

                    // before removing tag we check option element of tag and

                    // if it has property 'locked' we will create error to prevent all select2 functionality

                    if ($(e.params.args.data.element).attr('locked')) {

                        e.preventDefault();

                    }

                });

        });

        $('#vendor').change(function() {

            var id = $(this).val();

            $.ajax({

                url: "{{ route('vendorproduct') }}",

                type: "POST",

                data: {

                    _token: '{{ csrf_token() }}',

                    id: id,

                },

                success: function(response) {

                    var vendordata = response.vendordata;

                    var details = '';

                    $.each(vendordata, function(index, value) {

                        details += '<option value="' + value.id + '|' + value.product_id + '|' +
                            value.title + '|' + value.vendor_item_id + '">' + value.title +
                            '</option>';

                    });

                    $('#vendoritems').html(details);

                }

            })

        });

        var data = [{{ implode(',', $arr) }}];

        var i = {{ $c + 1 }};

        $('.addproduct').change(function() {

            let len = $(this).val().length - 1;

            $.map($(this).val(), function(elementOfArray, indexInArray) {

                let vendor_item_id = elementOfArray.split('|')[0];

                let pid = elementOfArray.split('|')[1];

                let product_name = elementOfArray.split('|')[2];

                let ele = parseInt(elementOfArray.split('|')[1]);

                let vendor_item_id1 = elementOfArray.split('|')[3];

                console.log(ele);

                if (data.includes(ele) == false) {

                    let details = ' <div class="row " id="child' + i + '">' +

                        '<div class="col-md-11">' +

                        '<div class="form-group row">' +

                        '<label for="example-text-input" class="col-sm-4 col-form-label">Product Name</label>' +

                        '<div class="col-sm-8">' +

                        '<input type="hidden" value=' + pid + ' name="product_id[]" id="product_id' + pid +
                        '" disabled="true">' +

                        '<input type="hidden" value=' + vendor_item_id1 +
                        ' name="vendor_items_id" id="vendor_items_id' + pid + '" disabled="true">' +

                        '<input type="hidden" value=' + vendor_item_id +
                        ' name="vendor_item_id[]" id="vendor_item_id' + pid + '" disabled="true">' +

                        '<input class="form-control" type="text" name="product_name[]" id="product_name' +
                        pid + '" readonly disabled="true" value="' + product_name +
                        '" placeholder="Enter" id="example-text-input">' +

                        '</div>' +

                        '</div>' +

                        '</div>' +

                        '<div class="col-md-12">' +

                        '<label for="example-text-input" class="col-form-label"><b>Product Attributes</label>' +

                        '</div>';

                    details += '<div class="col-md-12 attribute' + i +
                        '" style="background-color: #f9f9f9;">';

                    $.ajax({

                        url: "{{ route('vendorproductitem') }}",

                        type: "POST",

                        data: {

                            _token: '{{ csrf_token() }}',

                            id: vendor_item_id,

                        },

                        success: function(response) {

                            let vendoritemdata = response.vendoritemdata;

                            $.each(vendoritemdata, function(j, v) {

                                details += ' <div class="row " id="attrchild' + j +
                                    '">' +

                                    '<div class="col-md-3">' +

                                    '<div class="form-group row">' +

                                    '<label for="example-text-input" class="col-sm-4 col-form-label">Attribute Type</label>' +

                                    '<div class="col-sm-8">' +

                                    '<input class="form-control" type="hidden" name="attribute_id[' +
                                    pid + '][]" disabled="true" value="' + v
                                    .attribute_id +
                                    '" placeholder="Enter" id="attribute_id' + j + '-' +
                                    pid + '">' +

                                    '<input class="form-control" type="text" readonly disabled="true" name="attribute_name[' +
                                    pid + '][]" value="' + v.attribute_name +
                                    '" placeholder="Enter" id="attribute_name' + j +
                                    '-' + pid + '">' +

                                    '</div>' +

                                    '</div>' +

                                    '</div>';

                                details += '<div class="col-md-2">' +

                                    '<div class="form-group row">' +

                                    '<label for="example-text-input" class="col-sm-12 col-form-label">Attribute Value</label>' +

                                    '<div class="col-sm-10">' +

                                    '<input class="form-control" type="text" readonly  name="attribute_value[' +
                                    pid + '][]" disabled="true" value= "' + v
                                    .attribute_value +
                                    '" placeholder="Enter" id="attribute_value' + j +
                                    '-' + pid + '">' +

                                    '</div>' +

                                    '</div>' +

                                    '</div>';

                                details += '<div class="col-md-2">' +

                                    '<div class="form-group row">' +

                                    '<label for="example-text-input" class="col-sm-12 col-form-label">Quantity</label>' +

                                    '<div class="col-sm-10">' +

                                    '<input class="form-control" type="text"  name="qty[' +
                                    pid + '][]" value= "' + v.quantity +
                                    '"  disabled="true" placeholder="Enter" id="qty' +
                                    j + '-' + pid + '">' +

                                    '</div>' +

                                    '</div>' +

                                    '</div>';

                                details += '<div class="col-md-2">' +

                                    '<div class="form-group row">' +

                                    '<label for="example-text-input" class="col-sm-12 col-form-label">Price</label>' +

                                    '<div class="col-sm-10">' +

                                    '<input class="form-control" type="text"  name="buying_price[' +
                                    pid +
                                    '][]" value= "0" disabled="true" placeholder="Enter" id="buying_price' +
                                    j + '-' + pid + '">' +

                                    '</div>' +

                                    '</div>' +

                                    '</div>';

                                details += '<div class="col-md-2">' +

                                    '<div class="form-group row">' +

                                    '<label for="example-text-input" class="col-sm-12 col-form-label">Status</label>' +

                                    '<div class="col-sm-10">';

                                (v.status == "active") ?

                                details +=
                                    '<span class="badge badge-success">Active</span>'

                                    :

                                    details +=
                                    '<span class="badge badge-danger">Inactive</span>'

                                details += '</div>' +

                                    '<div class="col-sm-0">';

                                (v.status == "active") ?

                                details +=
                                    '<input  type="checkbox" onclick="all1(this);"  data-id="' +
                                    j + '|' + pid +
                                    '" value="yes"  placeholder="Enter" id="all">'

                                    :

                                    details +=
                                    '<input  type="checkbox" disabled value="no"  placeholder="Enter" id="all">'

                                details += '</div>';

                                details += '</div>' +

                                    '</div>';

                                details += '</div>';

                            });

                            $('.product').append(details);

                        }

                    });

                    details += '</div>';

                    details += '</div>';

                    data.push(ele);

                }

                // else{

                //     alert('Already Add this Product! Choose Another One');

                // }

            });

            i++;

        });

        function all1(e) {

            var mode = $(e).prop('checked');

            var id = $(e).data('id').split('|')[0];

            var pid = $(e).data('id').split('|')[1];

            if (mode == true) {

                $('#vendor_item_id' + pid).prop('disabled', false);

                $('#vendor_items_id' + pid).prop('disabled', false);

                $('#product_id' + pid).prop('disabled', false);

                $('#product_name' + pid).prop('disabled', false);

                $('#attribute_id' + id + '-' + pid).prop('disabled', false);

                $('#attribute_name' + id + '-' + pid).prop('disabled', false);

                $('#attribute_value' + id + '-' + pid).prop('disabled', false);

                $('#qty' + id + '-' + pid).prop('disabled', false);

                $('#buying_price' + id + '-' + pid).prop('disabled', false);

            } else {

                $('#vendor_item_id' + pid).prop('disabled', true);

                $('#vendor_items_id' + pid).prop('disabled', true);

                $('#product_id' + pid).prop('disabled', true);

                $('#product_name' + pid).prop('disabled', true);

                $('#attribute_id' + id + '-' + pid).prop('disabled', true);

                $('#attribute_name' + id + '-' + pid).prop('disabled', true);

                $('#attribute_value' + id + '-' + pid).prop('disabled', true);

                $('#qty' + id + '-' + pid).prop('disabled', true);

                $('#buying_price' + id + '-' + pid).prop('disabled', true);

            }

            //console.log(id);

        }
    </script>
@endsection
