@extends('backend.layouts.master')

@section('content')
    <style>
        .card {

            overflow-x: scroll;

        }

        .table-hover tbody tr:hover,
        .table-striped tbody tr:nth-of-type(odd),
        .thead-default th {

            background-color: #fff;

        }

        .year {

            background-color: #dee2e6 !important;

        }

        .cate {

            background-color: #5e93ed;

        }

        .tax {

            font-weight: 700 !important;

            color: #000;

        }

        .table-height {

            height: auto !important;

        }
    </style>

    <div class="page-content-wrapper ">

        <div class="container-fluid">

            <div class="row">

                <div class="col-sm-12">

                    <div class="float-right page-breadcrumb">

                        <ol class="breadcrumb">

                            <li class="breadcrumb-item"><a href="#">Home</a></li>

                            <li class="breadcrumb-item"><a href="#">Report</a></li>

                            <li class="breadcrumb-item active">Expense Report</li>

                        </ol>

                    </div>

                    <h5 class="page-title">Expense Report</h5>

                </div>

            </div>

            <!-- end row -->

            <div class="row">

                <div class="col-12">

                    <div class="card m-b-30">

                        <div class="card-body">

                            <!-- <h4 class="mt-0 header-title">Example</h4>

                                                    <p class="text-muted m-b-30 font-14">This is an experimental awesome solution for responsive tables with complex data.</p>

                     -->

                            <div class="table-rep-plugin">

                                <div class="table-responsive b-0" data-pattern="priority-columns">

                                    <table id="tech-companies-1" class="table table-striped table-height">

                                        <thead>

                                            <tr>

                                                <!-- <th>Company</th> -->

                                                <th data-priority="1" class="cate">Product</th>

                                                <th data-priority="3" class="cate">Jan</th>

                                                <th data-priority="1" class="cate">Feb</th>

                                                <th data-priority="3" class="cate">Mar</th>

                                                <th data-priority="3" class="cate">Apr</th>

                                                <th data-priority="3" class="cate">May</th>

                                                <th data-priority="6" class="cate">Jun</th>

                                                <th data-priority="6" class="cate">Jul</th>

                                                <th data-priority="6" class="cate">Aug</th>

                                                <th data-priority="1" class="cate">Sep</th>

                                                <th data-priority="3" class="cate">Oct</th>

                                                <th data-priority="1" class="cate">Nov</th>

                                                <th data-priority="3" class="cate">Dec</th>

                                                <th data-priority="3" class="cate">Year(2022)</th>

                                            </tr>

                                        </thead>

                                        <tbody>

                                            @foreach ($data['product'] as $key => $item)
                                                <tr>

                                                    <th><span class="co-name">{{ $key }}</span></th>

                                                    @foreach ($data['product'][$key] as $k1 => $item)
                                                        @if ($k1 != 'year_total')
                                                            <td>${{ $item }}</td>
                                                        @else
                                                            <td class="year">${{ $item }}</td>
                                                        @endif
                                                    @endforeach

                                                    <!-- <td>731.10</td> -->

                                                </tr>
                                            @endforeach

                                            <tr class="year">

                                                <th class="tax"><span class="co-name">Net Amount<br>(Subtotal)</span>
                                                </th>

                                                @foreach ($data['total_exc'] as $k => $item)
                                                    @if ($k != 'overall_total_exc')
                                                        <td>${{ $item }}</td>
                                                    @else
                                                        <td class="year">${{ $item }}</td>
                                                    @endif
                                                @endforeach

                                                <!-- <td>731.10</td> -->

                                            </tr>

                                            <tr class="year">

                                                <th class="tax"><span class="co-name">Total Tax</span></th>

                                                @foreach ($data['total_tax'] as $k => $item)
                                                    @if ($k != 'overall_total_tax')
                                                        <td>${{ $item }}</td>
                                                    @else
                                                        <td class="year">${{ $item }}</td>
                                                    @endif
                                                @endforeach

                                                <!-- <td>731.10</td> -->

                                            </tr>

                                            <tr class="year">

                                                <th class="tax"><span class="co-name">Total</span></th>

                                                @foreach ($data['total_inc'] as $k => $item)
                                                    @if ($k != 'overall_total_inc')
                                                        <td>${{ $item }}</td>
                                                    @else
                                                        <td class="year">${{ $item }}</td>
                                                    @endif
                                                @endforeach

                                                <!-- <td>731.10</td> -->

                                            </tr>

                                        </tbody>

                                    </table>

                                </div>

                            </div>

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
        setTimeout(() => {

            $('.btn-toolbar').after(
                ' <a href="javascript:void(0);" class="btn btn-primary downloadpdf"  type="button">PDF</a><a href="" id="pdffile" download style="display:none" ></a>'
            );

        }, 1000);

        $('.downloadpdf').click(function() {

            var body = $('#tech-companies-1').html();

            $.ajax({

                url: "{{ route('report.pdf') }}",

                type: "POST",

                data: {

                    _token: '{{ csrf_token() }}',

                    data: JSON.stringify(body),

                },

                success: function(response) {

                    $("#pdffile").attr("href", response);

                    document.getElementById("pdffile").click();

                }

            })

        });
    </script>
@endsection
