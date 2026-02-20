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

                            <li class="breadcrumb-item active">Edit Vendor-Items</li>

                        </ol>

                    </div>

                    <h5 class="page-title">Edit Vendor-Items</h5>

                </div>

            </div>

            <div class="card m-b-30 card-body">

                <h4 class="card-title font-20 mt-0">Edit Vendor-Items</h4>

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

                            <form method="post" action="{{ route('vendoritem.update', $vendoritem->id) }}">

                                @csrf

                                @method('patch')

                                <div class="row">

                                    <div class="col-md-6">

                                        <div class="form-group row">

                                            <label for="example-text-input" class="col-sm-4 col-form-label">Vendor Item ID
                                            </label>

                                            <div class="col-sm-8">

                                                <input class="form-control" type="text" name="vendor_item_id"
                                                    placeholder="Enter" value="{{ $vendoritem->vendor_item_id }}" readonly
                                                    id="example-text-input">

                                            </div>

                                        </div>

                                    </div>

                                    <div class="col-md-6">

                                        <div class="form-group row">

                                            <label for="example-text-input" class="col-sm-4 col-form-label">Vendor Name
                                            </label>

                                            <div class="col-sm-8">

                                                <input class="form-control" type="text" name="vendor_name"
                                                    placeholder="Enter" value="{{ $vendoritem->vendor_name }}" readonly
                                                    id="example-text-input">

                                            </div>

                                        </div>

                                    </div>

                                    <div class=" col-md-12 product">

                                        <div class="row " id="child1">

                                            <div class="col-md-8">

                                                <div class="form-group row">

                                                    <label for="example-text-input" class="col-sm-4 col-form-label">Product
                                                        Name</label>

                                                    <div class="col-sm-8"><input type="hidden"
                                                            value="{{ $vendoritem->product_id }}" name="product_id">

                                                        <input type="hidden" value="{{ $vendoritem->tax_rate }}"
                                                            name="tax_rate">

                                                        @foreach (\App\Models\Product::where(['id' => $vendoritem->product_id])->get('title') as $item)
                                                            <input class="form-control" type="text" name="product_name"
                                                                placeholder="Enter" value="{{ $item->title }}" readonly
                                                                id="example-text-input">
                                                        @endforeach

                                                    </div>

                                                </div>
                                            </div>

                                            <div class="col-md-2">

                                                <div class="form-group row">

                                                    <label for="example-text-input" class="col-sm-4 col-form-label">Tax
                                                        Rate</label>

                                                    <div class="col-sm-8"><input type="hidden"
                                                            value="{{ $vendoritem->product_id }}" name="product_id">

                                                        @foreach (\App\Models\Product::where(['id' => $vendoritem->product_id])->get('tax_value') as $item)
                                                            <input class="form-control" type="text" name="tax_rate"
                                                                placeholder="Enter" value="{{ $item->tax_value }}" readonly
                                                                id="example-text-input">
                                                        @endforeach

                                                    </div>

                                                </div>

                                            </div>

                                            <div class="col-md-12">

                                                <label for="example-text-input" class="col-form-label"><b>Product
                                                        Attributes</b></label>

                                            </div>

                                            <!-- <div class="col-md-3">

                                                                    <div class="form-group row">

                                                                        <b><label for="example-text-input" class="col-sm-12 col-form-label">Attribute Type</label>

                                                                        <div class="col-sm-10">

                                                                            <select id="attr_type4" class="form-control">

                                                                                <option value="">Select Attribute Type</option>

                                                                                <option value="7|Color">Color</option>

                                                                                <option value="8|Color">Color</option>

                                                                                <option value="9|Storage">Storage</option>

                                                                                <option value="10|Storage">Storage</option>

                                                                            </select>

                                                                        </div>

                                                                    </b>

                                                                </div>

                                                            </div>

                                                            <div class="col-md-3">

                                                                <div class="form-group row">

                                                                    <b>

                                                                        <label for="example-text-input" class="col-sm-12 col-form-label">Attribute Value</label>

                                                                        <div class="col-sm-10">

                                                                            <select id="attr_value4" class="form-control">

                                                                                <option value="">Select Attribute Value</option>

                                                                                <option value="red">red</option>

                                                                                <option value="blue">blue</option>

                                                                                <option value="64GB">64GB</option>

                                                                                <option value="128gb">128gb</option>

                                                                            </select>

                                                                        </div>

                                                                    </b>

                                                                </div>

                                                            </div> -->

                                            <!-- <div class="col-md-3">

                                                                <div class="form-group row">

                                                                    <b><label for="example-text-input" class="col-sm-12 col-form-label">Quantity</label>

                                                                    <div class="col-sm-10">

                                                                        <input class="form-control" type="text" value="" placeholder="Enter" id="qty4">

                                                                    </div>

                                                                </b>

                                                            </div> -->

                                        </div>

                                        <div class="col-md-12 attribute4" style="background-color: #f9f9f9;">

                                            @foreach ($vendoritemattribute as $items)
                                                <div class="row " id="attrchild1">

                                                    <div class="col-md-3">

                                                        <div class="form-group row">

                                                            <label for="example-text-input"
                                                                class="col-sm-4 col-form-label">Attribute Type</label>

                                                            <div class="col-sm-8">

                                                                <input class="form-control" type="hidden"
                                                                    name="attribute_id[{{ $vendoritem->product_id }}][]"
                                                                    value="{{ $items->attribute_id }}"
                                                                    placeholder="Enter" id="example-text-input">

                                                                <input class="form-control" type="text" readonly
                                                                    name="attribute_name[{{ $vendoritem->product_id }}][]"
                                                                    value="{{ $items->attribute_name }}"
                                                                    placeholder="Enter" id="example-text-input">

                                                            </div>

                                                        </div>

                                                    </div>

                                                    <div class="col-md-3">

                                                        <div class="form-group row">

                                                            <label for="example-text-input"
                                                                class="col-sm-12 col-form-label">Attribute Value</label>

                                                            <div class="col-sm-10">

                                                                <input class="form-control" type="text" readonly
                                                                    name="attribute_value[{{ $vendoritem->product_id }}][]"
                                                                    value="{{ $items->attribute_value }}"
                                                                    placeholder="Enter" id="qty">

                                                            </div>

                                                        </div>

                                                    </div>

                                                    <div class="col-md-3">

                                                        <div class="form-group row">

                                                            <label for="example-text-input"
                                                                class="col-sm-12 col-form-label">Quantity</label>

                                                            <div class="col-sm-10">

                                                                <input class="form-control" type="text"
                                                                    name="qty[{{ $vendoritem->product_id }}][]"
                                                                    value="{{ $items->quantity }}" placeholder="Enter"
                                                                    id="qty">

                                                            </div>

                                                        </div>

                                                    </div>

                                                    <div class="col-md-3">

                                                        <div class="form-group row">

                                                            <label for="example-text-input"
                                                                class="col-sm-12 col-form-label">Buying Price</label>

                                                            <div class="col-sm-10">

                                                                <input class="form-control" type="text"
                                                                    name="buying_price[{{ $vendoritem->product_id }}][]"
                                                                    value="{{ $items->buying_price }}"
                                                                    placeholder="Enter" id="buying_price">

                                                            </div>

                                                        </div>

                                                    </div>

                                                    <div class="col-md-3">

                                                        <div class="form-group row">

                                                            <label for="example-text-input"
                                                                class="col-sm-12 col-form-label">Status</label>

                                                            <div class="col-sm-10">

                                                                <select name="status[{{ $vendoritem->product_id }}][]"
                                                                    id="" class="form-control">

                                                                    <option value="">--Select Status --</option>

                                                                    @if ($items->status == 'active')
                                                                        <option value="active" selected>Active</option>

                                                                        <option value="inactive">Inactive</option>
                                                                    @else
                                                                        <option value="active">Active</option>

                                                                        <option value="inactive" selected>Inactive</option>
                                                                    @endif

                                                                </select>

                                                            </div>

                                                        </div>

                                                    </div>

                                                </div>
                                            @endforeach

                                        </div>

                                    </div>

                                </div>

                                <div class="col-md-12 d-flex">

                                    <button class="btn btn-primary" type="submit">Submit</button>&nbsp;

                                    <!-- <button class="btn btn-secondary " type="submit">Cancel</button> -->

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

            attribute = JSON.parse(attribute);

            if (product) {

                if (data.includes($('#product').val().split('|')[0]) == false) {

                    var attr_name = '',
                        attr_val = '';

                    for (i = 0; i < attribute.length; i++) {

                        attr_name += '<option value="' + attribute[i]['id'] + '|' + attribute[i]['arrtibute_name'] +
                            '">' + attribute[i]['arrtibute_name'] + '</option>';

                        attr_val += '<option value="' + attribute[i]['arrtibute_value'] + '">' + attribute[i][
                            'arrtibute_value'
                        ] + '</option>';

                    }

                    let details = ' <div class="row " id="child' + i + '">' +

                        '<div class="col-md-11">' +

                        '<div class="form-group row">' +

                        '<label for="example-text-input" class="col-sm-4 col-form-label">Product Name</label>' +

                        '<div class="col-sm-8">' +

                        '<input type="hidden" value=' + productid + ' name="product_id[]" >' +

                        '<input class="form-control" type="text" name="product_name[]" readonly value="' + product +
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

                        '<select id="attr_type' + i + '" class="form-control">' +

                        '<option value="">Select Attribute Type</option>';

                    details += attr_name;

                    details += '</select>' +

                        '</div>' +

                        '</div>' +

                        '</div>';

                    details += '<div class="col-md-3">' +

                        '<div class="form-group row">' +

                        '<label for="example-text-input" class="col-sm-12 col-form-label">Attribute Value</label>' +

                        '<div class="col-sm-10">' +

                        '<select  id="attr_value' + i + '" class="form-control">' +

                        '<option value="">Select Attribute Value</option>';

                    details += attr_val;

                    details += '</select>' +

                        '</div>' +

                        '</div>' +

                        '</div>';

                    details += '<div class="col-md-3">' +

                        '<div class="form-group row">' +

                        '<label for="example-text-input" class="col-sm-12 col-form-label">Quantity</label>' +

                        '<div class="col-sm-10">' +

                        '<input class="form-control" type="text"   value= "" placeholder="Enter" id="qty' + i +
                        '">' +

                        '</div>' +

                        '</div>' +

                        '</div>';

                    details += '<div class="col-md-3">' +

                        '<div class="form-group row">' +

                        '<label for="example-text-input" class="col-sm-12 col-form-label">Buying Price</label>' +

                        '<div class="col-sm-10">' +

                        '<input class="form-control" type="text"   value= "" placeholder="Enter" id="buying_price' +
                        i + '">' +

                        '</div>' +

                        '</div>' +

                        '</div>';

                    details += '<div class="col-md-3">' +

                        '<div class="form-group row">' +

                        '<label for="example-text-input" class="col-sm-12 col-form-label"></label>' +

                        '<div class="col-md-3 col-sm-3">' +

                        '<button class="btn btn-primary addattribute" onclick="addattribute(' + i + ',' +
                        productid + ')" type="button" >Add </button>' +

                        '</div>' +

                        '</div>' +

                        '</div>';

                    details += '<div class="col-md-12 attribute' + i +
                        '" style="background-color: #f9f9f9;"></div>';

                    details += '</div>';

                    data.push($('#product').val().split('|')[0]);

                    $('.product').append(details);

                    $('#product').val('');

                } else {

                    swal("Attention", 'Already Add this Product! Choose Another One', "warning");

                }

            } else {

                swal("Attention", 'Please Select Product', "warning");

            }

            i++;

        });

        function addattribute(e, pid) {

            var attr_name = $('#attr_type' + e).val().split('|')[1];

            var attr_id = $('#attr_type' + e).val().split('|')[0];

            var attr_val = $('#attr_value' + e).val();

            var qty = $('#qty' + e).val();

            var buying_price = $('#buying_price' + e).val();

            if (attr_name) {

                let details1 = ' <div class="row " id="attrchild' + j + '">' +

                    '<div class="col-md-3">' +

                    '<div class="form-group row">' +

                    '<label for="example-text-input" class="col-sm-4 col-form-label">Attribute Type</label>' +

                    '<div class="col-sm-8">' +

                    '<input class="form-control" type="hidden" name="attribute_id[' + pid + '][]" value="' + attr_id +
                    '" placeholder="Enter" id="example-text-input">' +

                    '<input class="form-control" type="text" name="attribute_name[' + pid + '][]" value="' + attr_name +
                    '" placeholder="Enter" id="example-text-input">' +

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

                    '<div class="col-md-1 col-sm-0">' +

                    '<button class="btn btn-danger " onclick="removeattr(this)" type="button" id="attrchild' + j + '|' +
                    attr_val + '"><i class="fa fa-trash"></i></button>' +

                    '</div>' +

                    '</div>' +

                    '</div>';

                details1 += '</div>';

                attrdata.push(attr_val);

                $('.attribute' + e).append(details1);

            } else {

                swal("Attention", 'Please Select Attribute', "warning");

            }

            j++;

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
