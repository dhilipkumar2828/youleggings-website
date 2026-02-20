@extends('backend.layouts.master')

@section('content')

    <div class="page-content-wrapper ">

        <form class="" action="{{ route('inventory.store') }}" method="post">

            @csrf

            <div class="container-fluid">

                <div class="row">

                    <div class="col-sm-12">

                        <div class="float-right page-breadcrumb">

                            <ol class="breadcrumb">

                                <li class="breadcrumb-item"><a href="#"> Inventory</a></li>

                                <li class="breadcrumb-item active">Inventory Receiving Voucher</li>

                            </ol>

                        </div>

                        <h5 class="page-title">Inventory Receiving Voucher</h5>

                    </div>

                </div>

                <!-- end row -->

                <div class="col-lg-12">

                    @include('backend.layouts.notification')

                </div>

                <div class="row">

                    <div class="col-sm-12 col-md-6">

                        <div id="datatable-buttons_filter" class="dataTables_filter">

                        </div>

                    </div>

                    <div class="col-sm-12">

                        <div class="dt-buttons btn-group">

                        </div>

                    </div>

                </div>

                <div class="row">

                    <div class="col-lg-6">

                        <div class="card m-b-30">

                            <div class="card-body">

                                <!-- <h4 class="mt-0 header-title">Validation type</h4>

                                                    <p class="text-muted m-b-30 font-14">Parsley is a javascript form validation

                                                        library. It helps you provide your users with feedback on their form

                                                        submission before sending it to your server.</p> -->

                                <div class="form-group">

                                    <label>Delivery Number</label>

                                    <div>

                                        @if (count(\App\Models\Inventory::orderBy('id', 'DESC')->limit('1')->get('id')) > 0)
                                            @foreach (\App\Models\Inventory::orderBy('id', 'DESC')->limit('1')->get('delivery_number') as $item)
                                                <input class="form-control" type="text" name="delivery_number"
                                                    placeholder="Enter"
                                                    value="Receiving-0000{{ explode('-', $item->delivery_number)[1] + 1 }}"
                                                    readonly id="example-text-input">
                                            @endforeach
                                        @else
                                            <input class="form-control" type="text" name="delivery_number"
                                                placeholder="Enter" value="Receiving-00001" readonly
                                                id="example-text-input">
                                        @endif

                                    </div>

                                </div>

                                <div class="form-group ">

                                    <label>Purchase Order</label>

                                    <div>

                                        <select name="purchase_order" id="purchase_order" required class="form-control">

                                            <option value="">Select</option>

                                            @foreach (\App\Models\PurchaseOrder::orderBy('id', 'ASC')->get() as $key => $value)
                                                <!-- @if (old('purchase_order') == $value->id)
    <option value="{{ $value->id }}" selected>{{ $value->purchase_order_id }}</option>
@else
    -->

                                                <option value="{{ $value->id }}">{{ $value->purchase_order_id }}</option>

                                                <!--
    @endif -->
                                            @endforeach

                                        </select>

                                    </div>

                                </div>

                                <div class="form-group">

                                    <label>Supplier Name</label>

                                    <div>

                                        <select name="vendor_name" id="vendor_name" required class="form-control">

                                            <option value="">Select</option>

                                            @foreach (\App\Models\Vendor::orderBy('id', 'ASC')->get() as $key => $value)
                                                <option value="{{ $value->id }}">{{ $value->vendor_name }}</option>
                                            @endforeach

                                        </select>

                                    </div>

                                </div>

                                <div class="form-group">

                                    <label>Buyer</label>

                                    <div>

                                        <select name="buyer" id="buyer" required class="form-control">

                                            <option value="">Select</option>

                                            @foreach (\App\Models\User::orderBy('id', 'ASC')->get() as $key => $value)
                                                <option value="{{ $value->id }}">{{ $value->name }}</option>
                                            @endforeach

                                        </select>

                                    </div>

                                </div>

                                <div class="form-group">

                                    <label>Deliverer</label>

                                    <div>

                                        <input data-parsley-type="alphanum" required name="deliverer" type="text"
                                            class="form-control" placeholder="Deliverer" />

                                    </div>

                                </div>

                                <div class="form-group">

                                    <label>Note</label>

                                    <div>

                                        <textarea class="form-control" name="inventory_note" placeholder="Note" rows="5"></textarea>

                                    </div>

                                </div>

                            </div>

                        </div>

                    </div> <!-- end col -->

                    <!-- </div> end row -->

                    <!-- <div class="row"> -->

                    <div class="col-lg-6">

                        <div class="card m-b-30">

                            <div class="card-body">

                                <!-- <h4 class="mt-0 header-title">Validation type</h4>

                                                    <p class="text-muted m-b-30 font-14">Parsley is a javascript form validation

                                                        library. It helps you provide your users with feedback on their form

                                                        submission before sending it to your server.</p> -->

                                <form class="" action="#">

                                    <div class="form-group">

                                        <label>Accounting Date</label>

                                        <div>

                                            <div class="input-group">

                                                <input type="date" class="form-control" required name="accounting_date"
                                                    placeholder="mm/dd/yyyy" id="datepicker">

                                            </div><!-- input-group -->

                                        </div>

                                    </div>

                                    <div class="form-group">

                                        <label>Voucher Date</label>

                                        <div>

                                            <div class="input-group">

                                                <input type="date" class="form-control" required name="voucher_date"
                                                    placeholder="mm/dd/yyyy" id="datepicker">

                                            </div><!-- input-group -->

                                        </div>

                                    </div>

                                    <div class="form-group row">

                                        <label for="example-text-input" class="col-sm-6 col-form-label">Warehouse
                                            Name</label>

                                        <div class="col-sm-12">

                                            <select name="warehourse" id="warehourse" required class="form-control">

                                                <option value="">Select</option>

                                                @foreach (\App\Models\Warehouse::orderBy('id', 'ASC')->get() as $key => $value)
                                                    <!-- @if (old('purchase_order') == $value->id)
    <option value="{{ $value->id }}" selected>{{ $value->purchase_order_id }}</option>
@else
    -->

                                                    <option value="{{ $value->id }}">{{ $value->warehouse_name }}
                                                    </option>

                                                    <!--
    @endif -->
                                                @endforeach

                                            </select>

                                        </div>

                                    </div>

                                    <div class="form-group">

                                        <label>Invoice Number</label>

                                        <div>

                                            <input type="text" class="form-control" required id="invoice_val"
                                                placeholder="Invoice Number" />

                                            <input type="hidden" class="form-control" name="invoice_id" id="invoice_id"
                                                placeholder="Invoice Number" />

                                        </div>

                                    </div>

                                    <div class="form-group">

                                        <label>Expiry Date</label>

                                        <div>

                                            <div class="input-group">

                                                <input type="date" class="form-control" required name="expiry_date"
                                                    placeholder="mm/dd/yyyy" id="datepicker">

                                            </div><!-- input-group -->

                                        </div>

                                    </div>

                                </form>

                            </div>

                        </div>

                    </div> <!-- end col -->

                </div> <!-- end row -->

                <div class="row">

                    <div class="col-12">

                        <div class="card m-b-30">

                            <div class="card-body">

                                <!-- <h4 class="mt-0 header-title">Default Datatable</h4>

                                                    <p class="text-muted m-b-30 font-14">DataTables has most features enabled by

                                                        default, so all you need to do to use it with your own tables is to call

                                                        the construction function: <code>$().DataTable();</code>.

                                                    </p> -->

                                <table id="datatable" class="table table-bordered dt-responsive nowrap"
                                    style="border-collapse: collapse; border-spacing: 0; width: 100%;">

                                    <thead>

                                        <tr>

                                            <th>S.No</th>

                                            <th>Product ID</th>

                                            <th>Product Name</th>

                                            <th>Warehouse Name</th>

                                            <th>Attribute Name</th>

                                            <th>Attribute Value</th>

                                            <th>Quantity</th>

                                            <th>Unit Price</th>

                                            <!-- <th>Tax Rate</th> -->

                                            <!-- <th>Goods Value</th> -->

                                            <!-- <th>Tax Amount</th> -->

                                            <!-- <th>Expiry Date</th> -->

                                            <th>Note</th>

                                        </tr>

                                    </thead>

                                    <tbody class="products">

                                    </tbody>

                                </table>

                                <div class="row">

                                    <div class="form-group col-lg-6">

                                        <label>Total Tax Amount</label>

                                        <div>

                                            <input type="text" class="form-control" required id="total_tax"
                                                name="total_tax" placeholder="0.00" />

                                        </div>

                                    </div>

                                </div>

                                <div class="row">

                                    <div class="form-group col-lg-6" style="display:none;">

                                        <label>Value of inventory</label>

                                        <div>

                                            <input type="hidden" class="form-control" name="value_of_inventory"
                                                placeholder="0.00" />

                                        </div>

                                    </div>

                                    <div class="form-group col-lg-6">

                                        <label>Total payment</label>

                                        <div>

                                            <input type="text" class="form-control" name="total_amount"
                                                id="total_amount" required placeholder="0.00" />

                                        </div>

                                    </div>

                                </div>

                                <div class="form-group">

                                    <div>

                                        <button type="submit" class="btn btn-primary waves-effect waves-light">

                                            Submit

                                        </button>

                                        <button type="reset" class="btn btn-secondary waves-effect m-l-5">

                                            Cancel

                                        </button>

                                    </div>

                                </div>

                            </div>

                        </div> <!-- end col -->

                    </div> <!-- end row -->

        </form>

    </div><!-- container fluid -->

    </div> <!-- Page content Wrapper -->

    </div> <!-- content -->

@endsection

@section('scripts')
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

    <script>
        $.ajaxSetup({

            headers: {

                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')

            }

        });

        $('.dltBtn').click(function(e) {

            var form = $(this).closest('form');

            var dataID = $(this).data('id');

            e.preventDefault();

            swal({

                    title: "Are you sure?",

                    text: "Once deleted, you will not be able to recover",

                    icon: "warning",

                    buttons: true,

                    dangerMode: true,

                })

                .then((willDelete) => {

                    if (willDelete) {

                        form.submit();

                        swal("Poof! Your imaginary file has been deleted!", {

                            icon: "success",

                        });

                    } else {

                        swal("Your imaginary file is safe!");

                    }

                });

        });
    </script>

    <script>
        $('input[name=toogle]').change(function() {

            var mode = $(this).prop('checked');

            var id = $(this).val();

            // alert(id);

            $.ajax({

                url: "{{ route('product.status') }}",

                type: "POST",

                data: {

                    _token: '{{ csrf_token() }}',

                    mode: mode,

                    id: id,

                },

                success: function(response) {

                    //console.log(response.status);

                }

            })

        });

        $('#purchase_order').change(function() {

            var id = $(this).val();

            // alert(id);

            $.ajax({

                url: "{{ route('delivery_docket_details') }}",

                type: "POST",

                data: {

                    _token: '{{ csrf_token() }}',

                    id: id,

                },

                success: function(response) {

                    let data = response;

                    let purchase = data.purchase;

                    let purchaseproduct = data.purchasproduct;

                    let invoice = data.invoice;

                    $('#vendor_name').val(purchase.vendor_id);

                    $('#invoice_val').val(invoice[0].invoice_id);

                    $('#invoice_id').val(invoice[0].id);

                    let productlist = '';

                    let amount = 0;

                    let gstvalue = 0;

                    $.each(purchaseproduct, function(k, v) {

                        productlist += '<tr>' +

                            '<td><div class="custom-control custom-checkbox">' +

                            '<input type="checkbox" class="custom-control-input " checked onclick="productcheck(' +
                            k + ');" id="customCheck' + k +
                            '"  data-parsley-multiple="groups" >' +

                            '<label class="custom-control-label" for="customCheck' + k +
                            '"></label>' +

                            '<input type="hidden" name="productcheck[]" id="productcheck' + k +
                            '" value="approved" >' +

                            "<input type='hidden' name='productdata[]' value='[" + JSON
                            .stringify(v) + "]' >" +

                            '</div></td>' +

                            '<td>' + v.product_id + '</td>' +

                            '<td>' + v.product_name + '</td>' +

                            '<td>Warhouse1</td>' +

                            '<td>' + v.attribute_name + '</td>' +

                            '<td>' + v.attribute_value + '</td>' +

                            '<td>' + v.quantity + '</td>' +

                            '<td>' + v.buying_price + '</td>' +

                            '<td></td>' +

                            '</tr>';

                        amount = amount + v.buying_price;

                        gstvalue = gstvalue + (v.buying_price / 100) * v.tax_rate;

                    });

                    $('.products').html(productlist);

                    $('#total_amount').val(amount);

                    $('#total_tax').val(gstvalue.toFixed(2));

                }

            })

        });

        function productcheck(id) {

            if ($('#customCheck' + id).prop('checked')) {

                $('#productcheck' + id).val('approved');

            } else {

                $('#productcheck' + id).val('disapproved');

            }

        }
    </script>
@endsection
