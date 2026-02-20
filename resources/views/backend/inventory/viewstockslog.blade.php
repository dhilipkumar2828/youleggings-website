@extends('backend.layouts.master')

@section('content')

    <?php
    
    function convertUtcToIst($utcTime)
    {
        // Ensure the UTC time is in a valid format (e.g., "2023-12-31 23:59:59")
    
        if (!preg_match('/^\d{4}-\d{2}-\d{2} \d{2}:\d{2}:\d{2}$/', $utcTime)) {
            throw new InvalidArgumentException("Invalid UTC time format: $utcTime");
        }
    
        // Create a DateTime object from the UTC time
    
        $utcDateTime = new DateTime($utcTime, new DateTimeZone('UTC'));
    
        // Set the timezone to IST
    
        $istDateTime = $utcDateTime->setTimezone(new DateTimeZone('Asia/Kolkata'));
    
        // Return the IST time as a string
    
        return $istDateTime->format('Y-m-d H:i:s');
    }
    
    ?>

    <div class="page-content-wrapper ">

        <div class="container-fluid">

            <div class="row">

                <div class="col-sm-12">

                    <div class="float-right page-breadcrumb">

                        <ol class="breadcrumb">

                            <li class="breadcrumb-item"><a href="#">Stocks Logs</a></li>

                        </ol>

                    </div>

                    <h5 class="page-title">Stocks Logs</h5>

                </div>

            </div>

            <div class="row">

                <div class="col-12">

                    @if ($errors->any())
                        <div class="alert alert-danger">

                            <ul>

                                @foreach ($errors->all() as $error)
                                    <li>

                                        {{ $error }}

                                    </li>
                                @endforeach

                            </ul>

                        </div>
                    @endif

                    <div class="col-lg-12">

                        @include('backend.layouts.notification')

                    </div>

                    <div class="card m-b-30">

                        <div class="card-body">

                            <table id="datatable" class="table table-bordered dt-responsive nowrap"
                                style="border-collapse: collapse; border-spacing: 0; width: 100%;">

                                <thead>

                                    <tr>

                                        <th>S.No</th>

                                        <th>Varient</th>

                                        <th>Stock In</th>

                                        <th>Stock Out</th>

                                        <th>Remarks</th>

                                        <th>Closure Qty</th>

                                        <th>Created At</th>

                                    </tr>

                                </thead>

                                <tbody>

                                    <?php
                                    
                                    $totalcnt = count($data);
                                    
                                    ?>

                                    @foreach ($data as $value)
                                        <tr>

                                            <td>

                                                <?php
                                                
                                                echo $totalcnt;
                                                
                                                $totalcnt = $totalcnt - 1;
                                                
                                                ?>

                                            </td>

                                            <td>{{ $value->size }} </td>

                                            <td style="text-align:center;">

                                                @if ($value->opr == 'ADD')
                                                    {{ $value->qty }}
                                                @endif

                                            </td>

                                            <td style="text-align:center;">

                                                @if ($value->opr == 'MINUS')
                                                    {{ $value->qty }}
                                                @endif

                                            </td>

                                            <td>

                                                {{ $value->remarks }}

                                            </td>

                                            <td style="text-align:center;">

                                                {{ $value->closure_qty }}

                                            </td>

                                            <td>

                                                {{ convertUtcToIst($value->created_at) }}

                                            </td>

                                        </tr>
                                    @endforeach

                                </tbody>

                            </table>

                        </div>

                    </div>

                </div> <!-- end col -->

            </div> <!-- end row -->

        </div><!-- container fluid -->

    </div> <!-- Page content Wrapper -->

@endsection

@section('scripts')
    <script>
        $('#datatable').dataTable({

            aaSorting: [
                [0, 'desc']
            ]

        })
    </script>
@endsection
