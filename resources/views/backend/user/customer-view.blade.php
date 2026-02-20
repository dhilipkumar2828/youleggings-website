@extends('backend.layouts.master')

@section('content')
    <div class="page-content-wrapper ">

        <div class="container-fluid">

            <div class="row">

                <div class="col-sm-12">

                    <div class="float-right page-breadcrumb">

                        <ol class="breadcrumb">

                            <!-- <li class="breadcrumb-item"><a href="#">Drixo</a></li> -->

                            <li class="breadcrumb-item"><a href="#">Customer</a></li>

                            <li class="breadcrumb-item active">Customer List</li>

                        </ol>

                    </div>

                    <h5 class="page-title">Customer Details</h5>

                </div>

            </div>

            <!-- end row -->

            <div class="card m-b-30 card-body">

                <h4 class="card-title font-20 mt-0">Customers Details</h4>

                <a href="{{ route('customer.list') }}" id="add-btn" style="color: #ffffff;"><i class="fa fa-angle-left"
                        aria-hidden="true"></i> Back</a>

            </div>

            <div class="row">

                <div class="col-12">

                    <div class="card m-b-30">

                        <div class="card-body">

                            <div class="row">

                                <div class="col-lg-6">

                                    <div class="form-group ">

                                        <label for="example-text-input" class="col-sm-10 col-form-label">First Name</label>

                                        <div class="col-sm-10">

                                            <input class="form-control" type="text" placeholder="Enter Name"
                                                id="example-text-input" name="name" value="{{ $customer->name }}">

                                        </div>

                                    </div>

                                </div>

                                <div class="col-lg-6">

                                    <div class="form-group ">

                                        <label for="example-text-input" class="col-sm-10 col-form-label">User Name</label>

                                        <div class="col-sm-10">

                                            <input class="form-control" type="text" placeholder="Enter Name"
                                                id="example-text-input" name="name" value="{{ $customer->user_name }}">

                                        </div>

                                    </div>

                                </div>

                                <div class="col-lg-6">

                                    <div class="form-group ">

                                        <label for="example-text-input" class="col-sm-10 col-form-label">Email</label>

                                        <div class="col-sm-10">

                                            <input class="form-control" type="text" placeholder="Enter Name"
                                                id="example-text-input" name="name" value="{{ $customer->email }}">

                                        </div>

                                    </div>

                                </div>

                                <div class="col-lg-6">

                                    <div class="form-group ">

                                        <label for="example-text-input" class="col-sm-10 col-form-label">Mobile
                                            Number</label>

                                        <div class="col-sm-10">

                                            <input class="form-control" type="text" placeholder="Enter Name"
                                                id="example-text-input" name="name" value="{{ $customer->phone }}">

                                        </div>

                                    </div>

                                </div>

                                <div class="col-lg-12">

                                    <label for="example-text-input" class="col-sm-12 col-form-label"><b>Billing
                                            Address</b></label>

                                </div>

                                <div class="col-lg-6">

                                    <div class="form-group ">

                                        <label for="example-text-input" class="col-sm-10 col-form-label">Address</label>

                                        <div class="col-sm-10">

                                            <input class="form-control" type="text" placeholder="Enter Name"
                                                id="example-text-input" name="name" value="{{ $customer->address }}">

                                        </div>

                                    </div>

                                </div>

                                <div class="col-lg-6">

                                    <div class="form-group ">

                                        <label for="example-text-input" class="col-sm-10 col-form-label">Country</label>

                                        <div class="col-sm-10">

                                            <input class="form-control" type="text" placeholder="Enter Name"
                                                id="example-text-input" name="name" value="{{ $customer->country }}">

                                        </div>

                                    </div>

                                </div>

                                <div class="col-lg-6">

                                    <div class="form-group ">

                                        <label for="example-text-input" class="col-sm-10 col-form-label">State</label>

                                        <div class="col-sm-10">

                                            <input class="form-control" type="text" placeholder="Enter Name"
                                                id="example-text-input" name="name" value="{{ $customer->state }}">

                                        </div>

                                    </div>

                                </div>

                                <div class="col-lg-6">

                                    <div class="form-group ">

                                        <label for="example-text-input" class="col-sm-10 col-form-label">City</label>

                                        <div class="col-sm-10">

                                            <input class="form-control" type="text" placeholder="Enter Name"
                                                id="example-text-input" name="name" value="{{ $customer->city }}">

                                        </div>

                                    </div>

                                </div>

                                <div class="col-lg-6">

                                    <div class="form-group ">

                                        <label for="example-text-input" class="col-sm-10 col-form-label">Pincode</label>

                                        <div class="col-sm-10">

                                            <input class="form-control" type="text" placeholder="Enter Name"
                                                id="example-text-input" name="name" value="{{ $customer->postcode }}">

                                        </div>

                                    </div>

                                </div>

                                <div class="col-lg-12">

                                    <label for="example-text-input" class="col-sm-12 col-form-label"><b>Shipping
                                            Address</b></label>

                                </div>

                                <div class="col-lg-6">

                                    <div class="form-group ">

                                        <label for="example-text-input" class="col-sm-10 col-form-label">Address</label>

                                        <div class="col-sm-10">

                                            <input class="form-control" type="text" placeholder="Enter Name"
                                                id="example-text-input" name="name"
                                                value="{{ $customer->saddress }}">

                                        </div>

                                    </div>

                                </div>

                                <div class="col-lg-6">

                                    <div class="form-group ">

                                        <label for="example-text-input" class="col-sm-10 col-form-label">Country</label>

                                        <div class="col-sm-10">

                                            <input class="form-control" type="text" placeholder="Enter Name"
                                                id="example-text-input" name="name"
                                                value="{{ $customer->scountry }}">

                                        </div>

                                    </div>

                                </div>

                                <div class="col-lg-6">

                                    <div class="form-group ">

                                        <label for="example-text-input" class="col-sm-10 col-form-label">State</label>

                                        <div class="col-sm-10">

                                            <input class="form-control" type="text" placeholder="Enter Name"
                                                id="example-text-input" name="name" value="{{ $customer->sstate }}">

                                        </div>

                                    </div>

                                </div>

                                <div class="col-lg-6">

                                    <div class="form-group ">

                                        <label for="example-text-input" class="col-sm-10 col-form-label">City</label>

                                        <div class="col-sm-10">

                                            <input class="form-control" type="text" placeholder="Enter Name"
                                                id="example-text-input" name="name" value="{{ $customer->scity }}">

                                        </div>

                                    </div>

                                </div>

                                <div class="col-lg-6">

                                    <div class="form-group ">

                                        <label for="example-text-input" class="col-sm-10 col-form-label">Pincode</label>

                                        <div class="col-sm-10">

                                            <input class="form-control" type="text" placeholder="Enter Name"
                                                id="example-text-input" name="name"
                                                value="{{ $customer->spostcode }}">

                                        </div>

                                    </div>

                                </div>

                                <div class="col-lg-6">

                                </div>

                                <div class="col-lg-6">

                                    <div class="form-group ">

                                        <label for="example-text-input" class="col-sm-10 col-form-label">Status</label>

                                        <div class="col-sm-10">

                                            <span
                                                class="badge {{ $customer->name == 'active' ? 'badge-success' : 'badge-danger' }}">{{ $customer->status }}</span>

                                        </div>

                                    </div>

                                </div>

                            </div>

                        </div>

                    </div>

                </div> <!-- end col -->

            </div> <!-- end row -->

        </div><!-- container fluid -->

    </div> <!-- Page content Wrapper -->

    </div> <!-- content -->

    </div>

    <!-- End Right content here -->
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

                url: "{{ route('user.status') }}",

                type: "POST",

                data: {

                    _token: '{{ csrf_token() }}',

                    mode: mode,

                    id: id,

                },

                success: function(response) {

                    console.log(response.status);

                }

            })

        });

        $(":input").prop('readonly', true);
    </script>
@endsection
