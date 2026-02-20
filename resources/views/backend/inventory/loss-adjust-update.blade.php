@extends('backend.layouts.master')

@section('content')
    <div class="page-content-wrapper ">

        <form class="" action="{{ route('inventory.update', $inventory->id) }}" method="post">

            @csrf

            @method('patch')

            <div class="container-fluid">

                <div class="row">

                    <div class="col-sm-12">

                        <div class="float-right page-breadcrumb">

                            <ol class="breadcrumb">

                                <li class="breadcrumb-item"><a href="#"> Inventory</a></li>

                                <li class="breadcrumb-item active">Inventory Loss Adjustment </li>

                            </ol>

                        </div>

                        <h5 class="page-title">Inventory Loss Adjustment </h5>

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

                                        <input class="form-control" type="text" name="delivery_number" readonly
                                            placeholder="Enter" value="{{ $inventory->delivery_number }}" readonly
                                            id="example-text-input">

                                        <input class="form-control" type="hidden" name="inventory_id" readonly
                                            placeholder="Enter" value="{{ $inventory->inventory_id }}" readonly
                                            id="example-text-input">

                                    </div>

                                </div>

                                <div class="form-group ">

                                    <label>Purchase Order</label>

                                    <div>

                                        <select name="purchase_order" id="purchase_order" class="form-control" readonly>

                                            <option value="">Select</option>

                                            @foreach (\App\Models\PurchaseOrder::where('id', $inventory->purchase_order_id)->orderBy('id', 'ASC')->get() as $key => $value)

                                                <!-- @if (old('purchase_order') == $value->id)
    <option value="{{ $value->id }}" selected>{{ $value->purchase_order_id }}</option>
@else
    -->

                                                <option value="{{ $value->id }}" selected>{{ $value->purchase_order_id }}
                                                </option>

                                                <!--
    @endif -->

                                            @endforeach

                                        </select>

                                    </div>

                                </div>

                                <div class="form-group">

                                    <label>Supplier Name</label>

                                    <div>

                                        <select name="vendor_name" id="vendor_name" class="form-control" readonly>

                                            <option value="">Select</option>

                                            @foreach (\App\Models\Vendor::where('id', $inventory->vendor_id)->orderBy('id', 'ASC')->get() as $key => $value)

                                                <option value="{{ $value->id }}" selected>{{ $value->vendor_name }}
                                                </option>

                                            @endforeach

                                        </select>

                                    </div>

                                </div>

                                <div class="form-group">

                                    <label>Buyer</label>

                                    <div>

                                        <select name="buyer" id="buyer" class="form-control" readonly>

                                            <option value="">Select</option>

                                            @foreach (\App\Models\User::where('id', $inventory->buyer)->orderBy('id', 'ASC')->get() as $key => $value)

                                                <option value="{{ $value->id }}" selected>{{ $value->name }}</option>

                                            @endforeach

                                        </select>

                                    </div>

                                </div>

                                <div class="form-group">

                                    <label>Deliverer</label>

                                    <div>

                                        <input data-parsley-type="alphanum" name="deliverer" readonly type="text"
                                            value="{{ $inventory->deliverer }}" class="form-control"
                                            placeholder="Deliverer" />

                                    </div>

                                </div>

                                <div class="form-group">

                                    <label>Note</label>

                                    <div>

                                        <textarea class="form-control" name="inventory_note" readonly value="{{ $inventory->note }}" placeholder="Note"
                                            rows="5">{{ $inventory->note }}</textarea>

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

                                                <input type="date" class="form-control" readonly name="accounting_date"
                                                    value="{{ $inventory->accounting_date }}" placeholder="mm/dd/yyyy"
                                                    id="datepicker">

                                            </div><!-- input-group -->

                                        </div>

                                    </div>

                                    <div class="form-group">

                                        <label>Voucher Date</label>

                                        <div>

                                            <div class="input-group">

                                                <input type="date" class="form-control" readonly name="voucher_date"
                                                    value="{{ $inventory->voucher_date }}" placeholder="mm/dd/yyyy"
                                                    id="datepicker">

                                            </div><!-- input-group -->

                                        </div>

                                    </div>

                                    <div class="form-group row">

                                        <label for="example-text-input" class="col-sm-6 col-form-label">Warehouse
                                            Name</label>

                                        <div class="col-sm-12">

                                            <select name="warehourse" id="warehourse" class="form-control">

                                                <option value="">Select</option>

                                                @foreach (\App\Models\Warehouse::orderBy('id', 'ASC')->get() as $key => $value)

                                                    @if ($inventory->warehouse == $value->id)
                                                        <option value="{{ $value->id }}" selected>
                                                            {{ $value->warehouse_name }}</option>
                                                    @else
                                                        <option value="{{ $value->id }}">{{ $value->warehouse_name }}
                                                        </option>
                                                    @endif

                                            </select>

                                        </div>

                                    </div>

                                    <div class="form-group">

                                        <label>Invoice Number</label>

                                        <div>

                                            <input type="text" class="form-control" readonly
                                                value="{{ \App\Models\Invoice::where('id', $inventory->invoice_id)->get()[0]['invoice_id'] }}"
                                                id="invoice_val" placeholder="Invoice Number" />

                                            <input type="hidden" class="form-control" readonly name="invoice_id"
                                                id="invoice_id" value="{{ $inventory->invoice_id }}"
                                                placeholder="Invoice Number" />

                                        </div>

                                    </div>

                                    <div class="form-group">

                                        <label>Expiry Date</label>

                                        <div>

                                            <div class="input-group">

                                                <input type="date" class="form-control" readonly name="expiry_date"
                                                    value="{{ $inventory->expiry_date }}" placeholder="mm/dd/yyyy"
                                                    id="datepicker">

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

                                        @foreach ($inventoryproduct as $data)

                                            <tr>

                                                <td>
                                                    <div class="custom-control custom-checkbox">

                                                        <input type="checkbox" class="custom-control-input "
                                                            onclick="productcheck('{{ $data->id }}');"
                                                            id="customCheck{{ $data->id }}"
                                                            data-parsley-multiple="groups" data-parsley-mincheck="2">

                                                        <label class="custom-control-label"
                                                            for="customCheck{{ $data->id }}"></label>

                                                        <input type="hidden" name="productcheck[]"
                                                            id="productcheck{{ $data->id }}"
                                                            value="{{ $data->product_status }}">

                                                        <input type='hidden' name='productdata[]'
                                                            value='[{{ json_encode($data) }}]'>

                                                    </div>
                                                </td>

                                                <td>{{ $data->product_id }}</td>

                                                <td>{{ $data->product_name }}</td>

                                                <td>{{ $data->warehouse }}</td>

                                                <td>{{ $data->attribute_name }}</td>

                                                <td>{{ $data->attribute_value }}</td>

                                                <td>{{ $data->quantity }}</td>

                                                <td>{{ $data->buying_price }}</td>

                                                <td></td>

                                            </tr>

                                        @endforeach

                                    </tbody>

                                </table>

                                <div class="row">

                                    <div class="form-group col-lg-6">

                                        <label>Total Tax Amount</label>

                                        <div>

                                            <input type="text" class="form-control"
                                                value="{{ $inventory->total_tax }}" id="total_tax" name="total_tax"
                                                placeholder="0.00" />

                                        </div>

                                    </div>

                                </div>

                                <div class="row">

                                    <div class="form-group col-lg-6" style="display:none;">

                                        <label>Value of inventory</label>

                                        <div>

                                            <input type="hidden" class="form-control"
                                                value="{{ $inventory->value_of_inventory }}" name="value_of_inventory"
                                                data-parsley-minlength="6" placeholder="0.00" />

                                        </div>

                                    </div>

                                    <div class="form-group col-lg-6">

                                        <label>Total payment</label>

                                        <div>

                                            <input type="text" class="form-control" name="total_amount"
                                                value="{{ $inventory->total_amount }}" id="total_amount" required
                                                data-parsley-minlength="6" placeholder="0.00" />

                                        </div>

                                    </div>

                                </div>

                                <div class="row">

                                    <div class="form-group col-lg-6">

                                        <label>Adjust Date</label>

                                        <div>

                                            <input type="date" class="form-control" required name="adjust_date"
                                                value="{{ $inventory->adjust_date }}" placeholder="mm/dd/yyyy"
                                                id="datepicker">

                                        </div>

                                    </div>

                                    <div class="form-group col-lg-6">

                                        <label>Reason</label>

                                        <div>

                                            <textarea class="form-control" name="adjust_reason" value="{{ $inventory->adjust_reason }}" required
                                                placeholder="Note" rows="5">{{ $inventory->adjust_reason }}</textarea>

                                        </div>

                                    </div>

                                </div>

                                <div class="form-group">

                                    <div>

                                        <button type="submit" class="btn btn-primary waves-effect waves-light">

                                            Submit

                                        </button>

                                        <button type="reset" class="btn btn-secondary waves-effect m-l-5">

                                            Close

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

                        gstvalue = gstvalue + (v.buying_price / v.tax_rate);

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
