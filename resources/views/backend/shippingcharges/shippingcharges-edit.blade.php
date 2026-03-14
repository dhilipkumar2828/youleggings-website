@extends('backend.layouts.master')

@section('content')
    <div class="page-content-wrapper ">

        <div class="container-fluid">

            <div class="row">

                <div class="col-sm-12">

                    

                    <h5 class="page-title">Update Shipping Info</h5>

                </div>

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

                            <form action="{{ route('shippingcharges.update', $shipping_id) }}" method="post">

                                @csrf

                                @method('patch')

                                <div class="col-md-12">

                                    <table class="table table-bordered">

                                        <thead>

                                            <tr>

                                                <th scope="col">#</th>

                                                <th scope="col">From Amount</th>

                                                <th scope="col">To Amount</th>

                                                <th scope="col">Shipping Charges (TamilNadu / Pondicherry)</th>

                                                <th scope="col">Discount (TamilNadu / Pondicherry)</th>

                                                <th scope="col">Shipping Charges (Other States)</th>

                                                <th scope="col">Discount (Other States)</th>

                                            </tr>

                                        </thead>

                                        <tbody>

                                            @foreach ($shipping as $key => $item)
                                                <tr>

                                                    <th scope="row">{{ $key + 1 }}</th>

                                                    <td><input type="text" name="from_amount[]" id="form_amount"
                                                            class="form-control" placeholder="From Amount"
                                                            value="{{ $item->from }}"></td>

                                                    <td><input type="text" name="to_amount[]" id="to_amount"
                                                            class="form-control" placeholder="To Amount"
                                                            value="{{ $item->to }}"></td>

                                                    <td><input type="text" name="ship_amount[]" id="ship_amount"
                                                            class="form-control" placeholder="Shipping Charges"
                                                            value="{{ $item->amount }}"></td>

                                                    <td><input type="text" name="dis_amount[]" id="dis_amount"
                                                            class="form-control" placeholder="Discount Charges"
                                                            value="{{ $item->dis_amount }}"></td>

                                                    <td><input type="text" name="ship_amount1[]" id="ship_amount1"
                                                            class="form-control" placeholder="Shipping Charges"
                                                            value="{{ $item->amount1 }}"></td>

                                                    <td><input type="text" name="dis_amount1[]" id="dis_amount1"
                                                            class="form-control" placeholder="Discount Charges"
                                                            value="{{ $item->dis_amount1 }}"></td>

                                                </tr>
                                            @endforeach

                                        </tbody>

                                    </table>

                                </div>

                                <div class=" col-md-12 d-flex">

                                    <button class="btn btn-primary" type="submit">Update</button>&nbsp;

                                    <!-- <button class="btn btn-secondary" type="reset">Cancel</button> -->

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
