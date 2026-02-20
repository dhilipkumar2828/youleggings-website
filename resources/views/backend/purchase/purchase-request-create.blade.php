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

                            <li class="breadcrumb-item active">Create Purchase Request</li>

                        </ol>

                    </div>

                    <h5 class="page-title">Create Purchase Request</h5>

                </div>

            </div>

            <div class="card m-b-30 card-body">

                <h4 class="card-title font-20 mt-0">Create Purchase Request</h4>

                <a href="{{ route('purchase.index') }}" id="add-btn" style="color: #ffffff;"><i class="fa fa-angle-left"
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

                            <form method="post" action="{{ route('purchase.store') }}">

                                @csrf

                                <div class="row">

                                    <div class="col-md-6">

                                        <div class="form-group row">

                                            <label for="example-text-input" class="col-sm-4 col-form-label">Purchase Request
                                                Code <span style="color:red">*</span></label>

                                            <div class="col-sm-8">

                                                @if (count(\App\Models\Purchase::orderBy('id', 'DESC')->limit('1')->get('id')) > 0)
                                                    @foreach (\App\Models\Purchase::orderBy('id', 'DESC')->limit('1')->get('purchase_request_id') as $item)
                                                        <input class="form-control" type="text"
                                                            name="purchase_request_id" placeholder="Enter"
                                                            value="PR-0000{{ explode('-', $item->purchase_request_id)[1] + 1 }}"
                                                            readonly id="example-text-input">
                                                    @endforeach
                                                @else
                                                    <input class="form-control" type="text" name="purchase_request_id"
                                                        placeholder="Enter" value="PR-00001" readonly
                                                        id="example-text-input">
                                                @endif

                                            </div>

                                        </div>

                                    </div>

                                    <div class="col-md-6">

                                        <div class="form-group row">

                                            <label for="example-text-input" class="col-sm-4 col-form-label">Purchase Request
                                                Name</label>

                                            <div class="col-sm-8">

                                                <input class="form-control" type="text" placeholder="Enter " required
                                                    name="purchase_request_name" id="example-text-input">

                                            </div>

                                        </div>

                                    </div>

                                    <div class="col-md-6">

                                        <div class="form-group row">

                                            <label for="example-text-input" class="col-sm-4 col-form-label">Requester <span
                                                    style="color:red">*</span></label>

                                            <div class="col-sm-8">

                                                <select id="requester" name="requester" value="{{ old('requester') }}"
                                                    class="form-control" required>

                                                    <option value="">-- Select Requester --</option>

                                                    @foreach (\App\Models\User::orderBy('id', 'ASC')->get() as $key => $value)
                                                        @if (old('requester') == $value->id)
                                                            <option value="{{ $value->id }}" selected>{{ $value->name }}
                                                            </option>
                                                        @else
                                                            <option value="{{ $value->id }}">{{ $value->name }}</option>
                                                        @endif
                                                    @endforeach

                                                </select>

                                            </div>

                                        </div>

                                    </div>

                                    <div class="col-md-6">

                                        <div class="form-group row">

                                            <label for="example-text-input" class="col-sm-4 col-form-label">Vendor Name
                                                <span style="color:red">*</span></label>

                                            <div class="col-sm-8">

                                                <select id="vendor" name="vendor" value="{{ old('vendor') }}"
                                                    class="form-control" required>

                                                    <option value="">-- Select Vendor --</option>

                                                    @foreach (\App\Models\Vendor::orderBy('id', 'ASC')->get() as $key => $value)
                                                        @if (old('vendor') == $value->id)
                                                            <option value="{{ $value->id . '|' . $value->vendor_name }}"
                                                                selected>{{ $value->vendor_name }}</option>
                                                        @else
                                                            <option value="{{ $value->id . '|' . $value->vendor_name }}">
                                                                {{ $value->vendor_name }}</option>
                                                        @endif
                                                    @endforeach

                                                </select>

                                            </div>

                                        </div>

                                    </div>

                                    <div class="col-md-6">

                                        <div class="form-group row">

                                            <label for="example-text-input" class="col-sm-4 col-form-label">Products <span
                                                    style="color:red">*</span></label>

                                            <div class="col-sm-8">

                                                <select class="js-example-basic-single addproduct" id="vendoritems" required
                                                    placeholder="Select Products" style="width:100%;" multiple="multiple">

                                                </select>

                                            </div>

                                        </div>

                                    </div>

                                    <div class=" col-md-12 product">

                                    </div>

                                    <div class="col-md-12 d-flex">

                                        <button class="btn btn-primary" type="submit">Submit</button>&nbsp;

                                        <button class="btn btn-secondary" type="reset">Cancel</button>

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
        $(document).ready(function() {

            $('.js-example-basic-single').select2({

                // maximumSelectionLength: 4,

                placeholder: "Select Products",

            }).on('select2:unselecting', function(e) {

                var data1 = e.params.args.data.id;

                let pid1 = data1.split('|')[1];

                $('#child' + pid1).remove();

                $('.attribute' + pid1).remove();

                //removeing item in array

                data = jQuery.grep(data, function(value) {

                    return value != pid1;

                });

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
                            value.title + '|' + value.vendor_item_id + '|' + value.tax_rate +
                            '">' + value.title + '</option>';

                    });

                    $('#vendoritems').html(details);

                }

            })

        });

        var i = 1;

        var data = [];

        $('.addproduct').change(function() {

            let len = $(this).val().length - 1;

            $.map($(this).val(), function(elementOfArray, indexInArray) {

                let vendor_item_id = elementOfArray.split('|')[0];

                let pid = elementOfArray.split('|')[1];

                let product_name = elementOfArray.split('|')[2];

                let ele = elementOfArray.split('|')[1];

                let vendor_item_id1 = elementOfArray.split('|')[3];

                let tax_rate = elementOfArray.split('|')[4];

                if (data.includes(ele) == false) {

                    let details = ' <div class="row " id="child' + pid + '">' +

                        '<div class="col-md-8">' +

                        '<div class="form-group row">' +

                        '<label for="example-text-input" class="col-sm-4 col-form-label">Product Name <span style="color:red">*</span></label>' +

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

                        '<div class="col-md-2">' +

                        '<div class="form-group row">' +

                        '<label for="example-text-input" class="col-sm-4 col-form-label">Tax Rate</label>' +

                        '<div class="col-sm-8">' +

                        '<input class="form-control" type="text" name="tax_rate[]" id="tax_rate' + pid +
                        '" readonly disabled="true" value="' + tax_rate +
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

                                details += ' <div class="row attribute' + pid +
                                    '" id="attrchild' + j + '">' +

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
                                    pid + '][]" value= "' + v.buying_price +
                                    '" disabled="true" placeholder="Enter" id="buying_price' +
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
                                    '<input  type="checkbox" onclick="all1(this);" required data-id="' +
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

                //     swal("Attention", 'Already Add this Product! Choose Another One', "warning");

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

                $('#tax_rate' + pid).prop('disabled', false);

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

                $('#tax_rate' + pid).prop('disabled', true);

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
