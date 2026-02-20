<!DOCTYPE html>

<html lang="en">

<head>

    <meta charset="utf-8">

    <meta name="viewport" content="width=device-width, initial-scale=1">

    <meta http-equiv="x-ua-compatible" content="ie=edge">

    <title>Expense PDF</title>

    <style>
        body {

            font-family: "Courier New", Courier, "Lucida Sans Typewriter", "Lucida Typewriter", monospace !important;

            letter-spacing: -0.3px;

        }

        .invoice-wrapper {
            width: 700px;
            margin: auto;
        }

        .nav-sidebar .nav-header:not(:first-of-type) {
            padding: 1.7rem 0rem .5rem;
        }

        .logo {
            font-size: 50px;
        }

        .sidebar-collapse .brand-link .brand-image {
            margin-top: -33px;
        }

        .content-wrapper {
            margin: auto !important;
        }

        .billing-company-image {
            width: 50px;
        }

        .billing_name {
            text-transform: uppercase;
        }

        .billing_address {
            text-transform: capitalize;
        }

        .table {
            width: 100%;
            border-collapse: collapse;
        }

        th {
            text-align: left;
            padding: 10px;
        }

        td {
            padding: 10px;
            vertical-align: top;
        }

        .row {
            display: block;
            clear: both;
        }

        .text-right {
            text-align: right;
        }

        .table-hover thead tr {
            background: #eee;
        }

        .table-hover tbody tr:nth-child(odd) {
            background: #fbf9f9;
        }

        address {
            font-style: normal;
        }

        .year {

            background-color: #dee2e6 !important;

        }
    </style>

</head>

<body>

    <div class="row invoice-wrapper">

        <div class="col-md-12">

            <div class="row">

                <div class="col-md-12 table-responsive">

                    <table class="table table-condensed table-hover">

                        @php

                            $data = json_decode($bodydata, true);

                            echo $data;

                        @endphp

                    </table>

                </div>

                <!-- /.col -->

            </div>

        </div>

    </div>

</body>

</html>
