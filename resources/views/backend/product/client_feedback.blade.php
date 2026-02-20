@extends('backend.layouts.master')

@section('content')
    <style>
        .switch-on.btn {
            padding-right: 1rem !important;
        }
    </style>
    <div class="page-content-wrapper ">

        <div class="container-fluid">

            <div class="row">
                <div class="col-sm-12">
                    <div class="float-right page-breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a>Catalogs</a></li>
                            <li class="breadcrumb-item"><a href="#"> Product</a></li>
                            <li class="breadcrumb-item active">Product Reviews</li>
                        </ol>
                    </div>
                    <h5 class="page-title">Catalogs</h5>

                </div>
            </div>
            <!-- end row -->
            <div class="card m-b-30 card-body">
                <h4 class="card-title font-20 mt-0">Client Feedback</h4>
                <!-- <a href="tags-create.html" id="add-btn" style="color: #ffffff;"> + ADD</a> -->

            </div>

            <div class="row">
                <div class="col-12">
                    <div class="card m-b-30">
                        <div class="card-body">

                            <table id="datatable" class="table table-bordered dt-responsive nowrap"
                                style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                <thead>
                                    <tr>
                                        <th>S.No</th>
                                        <th>Customer</th>
                                        <th>Mobile Number</th>
                                        <th> Review</th>
                                        <th> Rating</th>
                                        <th> Date</th>
                                        @if (auth()->user()->can('product_review-edit'))
                                            <th> Status</th>
                                        @endif
                                        <!--<th>Actions</th>-->
                                    </tr>
                                </thead>

                                <tbody>
                                    @foreach ($productreviews as $key => $item)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $item->name }}</td>
                                            <td>{{ $item->phone_number }}</td>
                                            <td>{{ $item->feedback }}</td>
                                            <td>{{ $item->rate }}</td>
                                            <td>{{ \Carbon\Carbon::parse($item->created_at)->format('d-M-Y') }}</td>
                                            @can('product_review-edit')
                                                <td><input type="checkbox" name="toogle" value="{{ $item->id }}"
                                                        data-toggle="switchbutton"
                                                        {{ $item->status == 'accept' ? 'checked' : '' }} data-onlabel="accept"
                                                        data-offlabel="reject" data-onstyle="success" data-offstyle="danger">
                                                </td>
                                            @endcan
                                            <!--<td>-->
                                            <!--    <div class="btn-group m-b-10">-->
                                            <!--        <button type="button" class="btn btn-action dropdown-toggle"-->
                                            <!--            data-toggle="dropdown" aria-haspopup="true"-->
                                            <!--            aria-expanded="false">Actions</button>-->
                                            <!--        <div class="dropdown-menu">-->
                                            <!-- <a class="dropdown-item" href="">Edit</a> -->
                                            <!--            <form action="{{ route('productriviewes.delete', $item->id) }}" method="post">-->
                                            <!--                @csrf-->
                                            <!--                @method('delete')-->
                                            <!--
                                            <!--                <a class="dltBtn btn waves-effect waves-light" title="delete"-->
                                            <!--                    data-id="{{ $item->id }}" data-toggle="modal" data-dismiss="modal"-->
                                            <!--                    data-target=".bs-example-modal-center">Delete</a><br>-->
                                            <!--
                                            <!--            </form>-->
                                            <!-- <a class="btn waves-effect waves-light" data-toggle="modal" data-dismiss="modal"
                                            <!--            data-target=".bs-example-modal-center1">View</a> -->
                                            <!--        </div>-->
                                            <!--    </div><!-- /btn-group -->
                                            <!--</td>-->
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>

                            <div class="col-sm-6 col-md-12 m-t-30">
                                <div class="modal fade bs-example-modal-center1" tabindex="-1" role="dialog"
                                    aria-labelledby="mySmallModalLabel" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title mt-0">View</h5>
                                                <button type="button" class="close" data-dismiss="modal"
                                                    aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <form>
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <div class="form-group row">
                                                                <label for="example-text-input"
                                                                    class="col-sm-6 col-form-label"> Name :</label>
                                                                <div class="col-sm-10">
                                                                    <input class="form-control" type="text"
                                                                        placeholder="Enter " id="example-text-input"
                                                                        disabled>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-12">
                                                            <div class="form-group row">
                                                                <label for="example-text-input"
                                                                    class="col-sm-6 col-form-label"> Status :</label>
                                                                <div class="col-sm-10">
                                                                    <select name="" id=""
                                                                        class="form-control" disabled>
                                                                        <option value=""></option>
                                                                        <option value=""></option>
                                                                        <option value=""></option>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                        </div>

                                                    </div>
                                                </form>

                                            </div>

                                            <div class="modal-button">
                                                <div class="button-items">
                                                    <button type="button" class="btn btn-secondary waves-effect"
                                                        data-dismiss="modal">Cancel</button>

                                                </div>
                                            </div>
                                        </div><!-- /.modal-content -->
                                    </div><!-- /.modal-dialog -->
                                </div><!-- /.modal -->
                            </div>
                        </div>
                    </div>
                </div> <!-- end col -->
            </div> <!-- end row -->

        </div><!-- container fluid -->

    </div> <!-- Page content Wrapper -->
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

        // $('.view').click(function(){
        //         var item=$(this).data('id');
        //        // alert(item);
        //         $.ajax({
        //             url:"{{ route('product_show') }}",
        //              type:"POST",
        //             data:{
        //                  _token:'{{ csrf_token() }}',
        //                  id:item
        //              },
        //              success:function (response)  {
        //                  //alert(response);
        //                // $('#image').src(response.image);
        //                document.getElementById("photo").src=response.photo;
        //                 $('#title').html(response.title);
        //                 $('#summary').html(response.summary);
        //                 $('#stock').html(response.stock);
        //                 $('#description').html(response.description);
        //                 $('#price').html(response.price);
        //                 $('#offer_price').html(response.offer_price);
        //                 $('#discount').html(response.discount);
        //                 $('#category').html(response.category);
        //                 $('#sub_category').html(response.sub_category);
        //                 $('#brand').html(response.brand);
        //                 $('#size').html(response.size);
        //                 $('#conditions').html(response.conditions);
        //                 if(response.status == 'active'){
        //                     $('#pstatus').html('<span  class="badge badge-success">'+response.status+'</span>');
        //                 }
        //                 else{
        //                     $('#pstatus').html('<span  class="badge badge-danger">'+response.status+'</span>');

        //                 }

        //              }
        //          })

        //     });
    </script>

    <script>
        $('input[name=toogle]').change(function() {
            var mode = $(this).prop('checked');
            var id = $(this).val();
            // alert(id);
            $.ajax({
                url: "{{ route('client_riviewes.status') }}",
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
    </script>
@endsection
