@extends('backend.layouts.master')

@section('content')
    <div class="page-content-wrapper ">

        <div class="container-fluid">

            <div class="row">

                <div class="col-sm-12">

                    <div class="float-right page-breadcrumb">

                        <ol class="breadcrumb">

                            <li class="breadcrumb-item"><a>Category Sorting</a></li>

                            <li class="breadcrumb-item"><a href="{{ route('category.index') }}">Header Sorting</a></li>

                        </ol>

                    </div>

                    <h5 class="page-title">Appearance</h5>

                </div>

            </div>

            <!-- end row -->

            <div class="card m-b-30 card-body">

                <h4 class="card-title font-20 mt-0">Header Sorting</h4>

            </div>

            <div class="row">

                <div class="col-lg-12">

                    @include('backend.layouts.notification')

                </div>

                <div class="col-12">

                    <div>

                    </div>

                    <div class="card m-b-30">

                        <div class="card-body">

                            <table id="table" class="table table-bordered">

                                <thead>

                                    <tr>

                                        <th width="30px">#</th>

                                        <th>Title</th>

                                    </tr>

                                </thead>

                                <tbody id="tablecontents">

                                    <!-- get all data from Table by Controller -->

                                    @foreach ($category as $post)
                                        <tr class="row1" data-id="{{ $post->id }}">

                                            <td class="pl-3"><i class="fa fa-sort"></i></td>

                                            <td>{{ $post->title }}</td>

                                        </tr>
                                    @endforeach

                                </tbody>

                            </table>

                        </div>

                    </div>

                </div> <!-- end col -->

            </div> <!-- end row -->

        </div><!-- container fluid -->

    </div>
@endsection

@section('scripts')
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>

    <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.10.3/jquery-ui.min.js"></script>

    <!-- Required datatable js -->

    <script src="{{ asset('assets/plugins/datatables/jquery.dataTables.min.js') }}"></script>

    <script src="{{ asset('assets/plugins/datatables/dataTables.bootstrap4.min.js') }}"></script>

    <!-- Buttons examples -->

    <script src="{{ asset('assets/plugins/datatables/dataTables.buttons.min.js') }}"></script>

    <script src="{{ asset('assets/plugins/datatables/buttons.bootstrap4.min.js') }}"></script>

    <script src="{{ asset('assets/plugins/datatables/jszip.min.js') }}"></script>

    <script src="{{ asset('assets/plugins/datatables/pdfmake.min.js') }}"></script>

    <script src="{{ asset('assets/plugins/datatables/vfs_fonts.js') }}"></script>

    <script src="{{ asset('assets/plugins/datatables/buttons.html5.min.js') }}"></script>

    <script src="{{ asset('assets/plugins/datatables/buttons.print.min.js') }}"></script>

    <script src="{{ asset('assets/plugins/datatables/buttons.colVis.min.js') }}"></script>

    <!-- Responsive examples -->

    <script src="{{ asset('assets/plugins/datatables/dataTables.responsive.min.js') }}"></script>

    <script src="{{ asset('assets/plugins/datatables/responsive.bootstrap4.min.js') }}"></script>

    <!-- Datatable init js -->

    <script src="{{ asset('assets/pages/datatables.init.js') }}"></script>

    <script type="text/javascript">
        $.ajaxSetup({

            headers: {

                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')

            }

        });

        $(function() {

            $("#table").DataTable();

            // this is need to Move Ordera accordin user wish Arrangement

            $("#tablecontents").sortable({

                items: "tr",

                cursor: 'move',

                opacity: 0.6,

                update: function() {

                    sendOrderToServer();

                }

            });

            function sendOrderToServer() {

                var order = [];

                var token = $('meta[name="csrf-token"]').attr('content');

                //   by this function User can Update hisOrders or Move to top or under

                $('tr.row1').each(function(index, element) {

                    order.push({

                        id: $(this).attr('data-id'),

                        position: index + 1

                    });

                });

                // the Ajax Post update

                $.ajax({

                    type: "POST",

                    dataType: "json",

                    url: "{{ url('updates/headerpage') }}",

                    data: {

                        order: order,

                        "_token": "{{ csrf_token() }}",

                    },

                    success: function(response) {

                        if (response.status == "success") {

                            console.log(response);

                        } else {

                            console.log(response);

                        }

                    }

                });

            }

        });
    </script>
@endsection
