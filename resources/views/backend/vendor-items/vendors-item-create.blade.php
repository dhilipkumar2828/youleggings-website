@extends('backend.layouts.master')

@section('content')

    <div class="page-content-wrapper ">

        <div class="container-fluid">

            <div class="row">

                <div class="col-sm-12">

                    <div class="float-right page-breadcrumb">

                        <ol class="breadcrumb">

                            <li class="breadcrumb-item"><a href="#">Home</a></li>

                            <li class="breadcrumb-item"><a href="#">Purchase</a></li>

                            <li class="breadcrumb-item active">Create Vendor-Items</li>

                        </ol>

                    </div>

                    <h5 class="page-title">Create Vendor-Items</h5>

                </div>

            </div>

            <div class="card m-b-30 card-body">

                <h4 class="card-title font-20 mt-0">Create Vendor-Items</h4>

                <a href="{{ route('vendoritem.index') }}" id="add-btn" style="color: #ffffff;"><i class="fa fa-angle-left"
                        aria-hidden="true"></i> Back</a>

            </div>

            <div class="row">

                <div class="col-12">

                    <div class="card m-b-30">

                        <div class="card-body">

                            <!-- <h4 class="mt-0 header-title">Textual inputs</h4>

                                                    <p class="text-muted m-b-30 font-14">Here are examples of <code

                                                            class="highlighter-rouge">.form-control</code> applied to each

                                                        textual HTML5 <code class="highlighter-rouge">&lt;input&gt;</code> <code

                                                                class="highlighter-rouge">type</code>.</p> -->

                            <form method="post" action="{{ route('vendoritem.store') }}">

                                @csrf

                                <div class="row">

                                    <div class="col-md-4">

                                        <div class="form-group row">

                                            <label for="example-text-input" class="col-sm-4 col-form-label">Vendor Item ID
                                                <span style="color:red">*</span></label>

                                            <div class="col-sm-8">

                                                @if (count(\App\Models\VendorItem::orderBy('id', 'DESC')->limit('1')->get('vendor_item_id')) > 0)
                                                    @foreach (\App\Models\VendorItem::orderBy('id', 'DESC')->limit('1')->get('vendor_item_id') as $item)
                                                        <input class="form-control" type="text" name="vendor_item_id"
                                                            placeholder="Enter"
                                                            value="VI-0000{{ explode('-', $item->vendor_item_id)[1] + 1 }}"
                                                            readonly id="example-text-input">
                                                    @endforeach
                                                @else
                                                    <input class="form-control" type="text" name="vendor_item_id"
                                                        placeholder="Enter" value="VI-00001" readonly
                                                        id="example-text-input">
                                                @endif

                                            </div>

                                        </div>

                                    </div>

                                    <div class="col-md-4">

                                        <div class="form-group row">

                                            <label for="example-text-input" class="col-sm-4 col-form-label">Vendor Name
                                            </label>

                                            <div class="col-sm-8">

                                                <select name="vendor" id="vendor" required class="form-control"
                                                    required>

                                                    <option value="">-- Select Vendors --</option>

                                                    @foreach (\App\Models\Vendor::orderBy('id', 'DESC')->get() as $item)
                                                        <option value="{{ $item->id . '|' . $item->vendor_name }}">
                                                            {{ $item->vendor_name }}</option>
                                                    @endforeach

                                                </select>

                                            </div>

                                        </div>

                                    </div>

                                    @php

                                        $varr = [];

                                        foreach (\App\Models\VendorItem::orderBy('id', 'DESC')->get() as $item) {
                                            array_push($varr, $item->product_id);
                                        }

                                    @endphp

                                    <div class="col-md-4">

                                        <div class="form-group row">

                                            <label for="example-text-input" class="col-sm-4 col-form-label">Product Name
                                                <span style="color:red">*</span></label>

                                            <div class="col-sm-8">

                                                <select id="product" class="form-control" name="product_id">

                                                    <option value="">-- Select Products --</option>

                                                    @forelse(\App\Models\Product::orderBy('id','DESC')->get() as $item1)
                                                        <option
                                                            value="{{ $item1->id .'|' .$item1->title .'|' .\App\Models\ProductAttribute::orderBy('product_id', 'DESC')->where(['product_id' => $item1->id])->get() .'|' .$item1->tax_value }}">
                                                            {{ $item1->title }}</option>

                                                    @empty

                                                        <option value=""> No Products Found</option>
                                                    @endforelse

                                                </select>

                                                <button class="btn btn-primary addproduct" type="button"
                                                    style="float:right;margin-top:1em;">Add Product</button>

                                            </div>

                                        </div>

                                    </div>

                                    <div class=" col-md-12 product">

                                    </div>

                                    <div class="col-md-12 d-flex">

                                        <button class="btn btn-primary" type="submit">Submit</button>&nbsp;

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

@endsection

@section('scripts')
    <script>
        var i = 1,
            j = 1;

        var data = [];

        var attrdata = [];

        $('.addproduct').click(function() {

            var product = $('#product').val().split('|')[1];

            var productid = $('#product').val().split('|')[0];

            var attribute = $('#product').val().split('|')[2];

            var tax_rate = $('#product').val().split('|')[3];

            attribute = JSON.parse(attribute);

            if (product) {

                if (data.includes($('#product').val().split('|')[0]) == false) {

                    var attr_name = '',
                        attr_val = '';

                    for (let p = 0; p < attribute.length; p++) {

                        attr_name += '<option value="' + attribute[p]['id'] + '|' + attribute[p]['arrtibute_name'] +
                            '">' + attribute[p]['arrtibute_name'] + '</option>';

                        attr_val += '<option value="' + attribute[p]['arrtibute_value'] + '">' + attribute[p][
                            'arrtibute_value'
                        ] + '</option>';

                    }

                    let details = ' <div class="row " id="child' + i + '">' +

                        '<div class="col-md-8">' +

                        '<div class="form-group row">' +

                        '<label for="example-text-input" class="col-sm-4 col-form-label">Product Name</label>' +

                        '<div class="col-sm-8">' +

                        '<input type="hidden" value=' + productid + ' name="product_id[]" >' +

                        '<input type="hidden" value=' + tax_rate + ' name="tax_rate[]" >' +

                        '<input class="form-control" type="text" name="product_name[]" readonly value="' + product +
                        '" placeholder="Enter" id="example-text-input">' +

                        '</div>' +

                        '</div>' +

                        '</div>' +

                        '<div class="col-md-2">' +

                        '<div class="form-group row">' +

                        '<label for="example-text-input" class="col-sm-4 col-form-label">Tax Rate</label>' +

                        '<div class="col-sm-8">' +

                        '<input class="form-control" type="text"   readonly  value="' + tax_rate +
                        '" placeholder="Enter" id="example-text-input">' +

                        '</div>' +

                        '<div class="col-md-1 col-sm-0">' +

                        '<button class="btn btn-danger " onclick="removeproduct(this)" type="button" id="child' +
                        i + '|' + productid + '"><i class="fa fa-trash"></i></button>' +

                        '</div>' +

                        '</div>' +

                        '</div>' +

                        '<div class="col-md-12">' +

                        '<label for="example-text-input" class="col-form-label"><b>Product Attributes</label>' +

                        '</div>';

                    details += '<div class="col-md-3">' +

                        '<div class="form-group row">' +

                        '<label for="example-text-input" class="col-sm-12 col-form-label">Attribute Type</label>' +

                        '<div class="col-sm-10">' +

                        '<select id="attr_type' + i + '" required class="form-control">' +

                        '<option value="">Select Attribute Type</option>';

                    details += attr_name;

                    details += '</select>' +

                        '</div>' +

                        '</div>' +

                        '</div>';

                    details += '<div class="col-md-3">' +

                        '<div class="form-group row">' +

                        '<label for="example-text-input" class="col-sm-12 col-form-label "   >Attribute Value <span style="color:red">*</span></label>' +

                        '<div class="col-sm-10">' +

                        '<select  id="attr_value' + i + '" required onchange="getvalues(this.value,' + productid +
                        ',' + i + ');" class="form-control">' +

                        '<option value="">Select Attribute Value</option>';

                    details += attr_val;

                    details += '</select>' +

                        '</div>' +

                        '</div>' +

                        '</div>';

                    details += '<div class="col-md-3">' +

                        '<div class="form-group row">' +

                        '<label for="example-text-input" class="col-sm-12 col-form-label">Quantity <span style="color:red">*</span></label>' +

                        '<div class="col-sm-10">' +

                        '<input class="form-control" required type="text"   value= "" placeholder="Enter" id="qty' +
                        i + '">' +

                        '</div>' +

                        '</div>' +

                        '</div>';

                    details += '<div class="col-md-3">' +

                        '<div class="form-group row">' +

                        '<label for="example-text-input" class="col-sm-12 col-form-label">Buying Price <span style="color:red">*</span></label>' +

                        '<div class="col-sm-10">' +

                        '<input class="form-control" required type="text"   value= "" placeholder="Enter" id="buying_price' +
                        i + '">' +

                        '</div>' +

                        '</div>' +

                        '</div>';

                    details += '<div class="col-md-3">' +

                        '<div class="form-group row">' +

                        '<label for="example-text-input" class="col-sm-12 col-form-label"> <span style="color:red">*</span></label>' +

                        '<div class="col-md-3 col-sm-3">' +

                        '<button class="btn btn-primary addattribute" onclick="addattribute(' + i + ',' +
                        productid + ')" type="button" >Add </button>' +

                        '</div>' +

                        '</div>' +

                        '</div>';

                    details += '<div class="col-md-12 attribute' + productid +
                        '" style="background-color: #f9f9f9;"></div>';

                    details += '</div>';

                    data.push($('#product').val().split('|')[0]);

                    $('.product').append(details);

                    $('#product').val('');

                    i++;

                } else {

                    swal("Attention", 'Already Add this Product! Choose Another One', "warning");

                }

            } else {

                swal("Attention", 'Please Select Product', "warning");

            }

        });

        function addattribute(e, pid) {

            var attr_name = $('#attr_type' + e).val().split('|')[1];

            var attr_id = $('#attr_type' + e).val().split('|')[0];

            var attr_val = $('#attr_value' + e).val();

            var qty = $('#qty' + e).val();

            var buying_price = $('#buying_price' + e).val();

            if (attr_name) {

                var attribute = $('#product').val().split('|')[2];

                //console.log(attribute1);

                var attr_name = '',
                    attr_val = '';

                for (let p = 0; p < attribute.length; p++) {

                    attr_name += '<option value="' + attribute[p]['id'] + '|' + attribute[p]['arrtibute_name'] + '">' +
                        attribute[p]['arrtibute_name'] + '</option>';

                    attr_val += '<option value="' + attribute[p]['arrtibute_value'] + '">' + attribute[p][
                        'arrtibute_value'
                    ] + '</option>';

                }

                let details1 = ' <div class="row " id="attrchild' + e + '">' +

                    '<div class="col-md-3">' +

                    '<div class="form-group row">' +

                    '<label for="example-text-input" class="col-sm-4 col-form-label">Attribute Type</label>' +

                    '<div class="col-sm-8">' +

                    '<input class="form-control" type="hidden" name="attribute_id[' + pid + '][]" value="' + attr_id +
                    '" placeholder="Enter" id="example-text-input">' +

                    '<div class="col-sm-10">' +

                    '<select id="attr_type' + i + '" required class="form-control">' +

                    '<option value="">Select Attribute Type</option>';

                details1 += attr_name;

                details1 += '</select>' +

                    '</div>' +

                    '</div>' +

                    '</div>' +

                    '</div>';

                details1 += '<div class="col-md-3">' +

                    '<div class="form-group row">' +

                    '<label for="example-text-input" class="col-sm-12 col-form-label">Attribute Value</label>' +

                    '<div class="col-sm-10">' +

                    '<input class="form-control" type="text"  name="attribute_value[' + pid + '][]" value= "' + attr_val +
                    '" placeholder="Enter" id="qty">' +

                    '</div>' +

                    '</div>' +

                    '</div>';

                details1 += '<div class="col-md-3">' +

                    '<div class="form-group row">' +

                    '<label for="example-text-input" class="col-sm-12 col-form-label">Quantity</label>' +

                    '<div class="col-sm-10">' +

                    '<input class="form-control" type="text"  name="qty[' + pid + '][]" value= "' + qty +
                    '" placeholder="Enter" id="qty">' +

                    '</div>' +

                    '</div>' +

                    '</div>';

                details1 += '<div class="col-md-3">' +

                    '<div class="form-group row">' +

                    '<label for="example-text-input" class="col-sm-12 col-form-label">Buying Price</label>' +

                    '<div class="col-sm-10">' +

                    '<input class="form-control" type="text"  name="buying_price[' + pid + '][]" value= "' + buying_price +
                    '" placeholder="Enter" id="buying_price">' +

                    '</div>' +

                    '</div>' +

                    '</div>';

                details1 += '<div class="col-md-3">' +

                    '<div class="form-group row">' +

                    '<label for="example-text-input" class="col-sm-12 col-form-label">Status</label>' +

                    '<div class="col-sm-10">' +

                    '<select name="status[' + pid + '][]" id="" class="form-control" >' +

                    '<option value="">--Select Status --</option>' +

                    '<option value="active" selected>Active</option>' +

                    '<option value="inactive">Inactive</option>' +

                    '</select>' +

                    '</div>' +

                    '<div class="col-md-1 col-sm-0">' +

                    '<button class="btn btn-danger " onclick="removeattr(this)" type="button" id="attrchild' + j + '|' +
                    attr_val + '"><i class="fa fa-trash"></i></button>' +

                    '</div>' +

                    '</div>' +

                    '</div>';

                details1 += '</div>';

                attrdata.push(attr_val);

                $('.attribute' + pid).append(details1);

            } else {

                swal("Attention", 'Please Select Attribute', "warning");

            }

            j++;

        }

        function getvalues(e, pid, idi) {

            var id = e;

            var pid = pid;

            // alert(id);

            $.ajax({

                url: "{{ route('getvalues') }}",

                type: "POST",

                data: {

                    _token: '{{ csrf_token() }}',

                    value: id,

                    pid: pid

                },

                success: function(response) {

                    //   console.log(response);

                    var data = response.product;

                    $('#qty' + idi).val(data[0].stock);

                    $('#buying_price' + idi).val(data[0].original_price);

                }

            })

        }

        function removeproduct(d) {

            var id = d.id.split('|')[0];

            var pid = d.id.split('|')[1];

            data = jQuery.grep(data, function(value) {

                return value != pid;

            });

            $('#' + id).remove();

        }

        function removeattr(d) {

            var id = d.id.split('|')[0];

            var pid = d.id.split('|')[1];

            data = jQuery.grep(attrdata, function(value) {

                return value != pid;

            });

            $('#' + id).remove();

        }
    </script>
@endsection
