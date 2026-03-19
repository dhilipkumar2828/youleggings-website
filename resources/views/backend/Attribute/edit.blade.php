@extends('backend.layouts.master')

@section('content')

    <div class="page-content-wrapper ">

        <div class="container-fluid">

            <div class="row">
                <div class="col-sm-12">
                    <div class="float-right page-breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('admin') }}">Home</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('attribute.index') }}">Attribute</a></li>
                            <li class="breadcrumb-item active">Edit Attribute</li>
                        </ol>
                    </div>
                    <h5 class="page-title">Edit Attribute</h5>

                </div>
            </div>
            <div class="card m-b-30">
                <div class="card-body d-flex align-items-center justify-content-between">
                    <div>
                        <h4 class="card-title font-20 mt-0 mb-1">Edit Attribute</h4>
                        <p class="text-muted mb-0">Modify details for: <span class="text-primary font-weight-bold">{{ $attribute->attribute_type }}</span></p>
                    </div>
                    <a href="{{ route('attribute.index') }}" class="btn btn-primary ripple px-4">
                        <i class="fa fa-angle-left mr-2"></i> Back to List
                    </a>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
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

                    @include('backend.layouts.notification')
                </div>
            </div> <!-- end row -->
        </div><!-- container fluid -->

    </div> <!-- Page content Wrapper -->

    <div class="row px-4">
        <div class="col-12">
            <div class="card m-b-30">
                <div class="card-body">
                    <form action="{{ route('attribute.update', $attribute->id) }}" method="POST">
                        @csrf
                        @method('patch')
                        
                        <div class="row">
                            <div class="col-md-5">
                                <div class="form-group pb-0">
                                    <label class="font-weight-bold">Attribute Type <span style="color:red">*</span></label>
                                    <input class="form-control" name="attribute_type" value="{{ $attribute->attribute_type }}" type="text" required placeholder="e.g. Size, Color">
                                    <span class="error"></span>
                                </div>
                            </div>
                            <div class="col-md-5">
                                <div class="form-group pb-0">
                                    <label class="font-weight-bold">Attribute Values <span style="color:red">*</span></label>
                                    <select class="js-example-basic-single" name="value[]" required style="width:100%;" multiple="multiple">
                                        @php
                                            $rawValues = $attribute->value;
                                            if (is_array($rawValues)) {
                                                foreach ($rawValues as $v) {
                                                    $cleanVal = is_string($v) ? trim($v, '"') : $v;
                                                    if (!empty($cleanVal)) {
                                                        echo '<option selected value="' . $cleanVal . '">' . $cleanVal . '</option>';
                                                    }
                                                }
                                            } else {
                                                $cleanVal = is_string($rawValues) ? trim($rawValues, '"') : $rawValues;
                                                if (!empty($cleanVal)) {
                                                    echo '<option selected value="' . $cleanVal . '">' . $cleanVal . '</option>';
                                                }
                                            }
                                        @endphp
                                    </select>
                                    <span class="error"></span>
                                </div>
                            </div>
                            <div class="col-md-2 d-flex align-items-end">
                                <div class="form-group mb-0">
                                    <button type="submit" class="btn btn btn-info ripple px-4 py-2 font-weight-bold">Update Attribute</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div> <!-- end col -->
    </div>

@endsection
@section('scripts')
    <script>
        $(document).ready(function() {
            $('.js-example-basic-single').select2({
                tags: true,
                placeholder: "Add Attribute",
                width: '100%',
                tokenSeparators: [',']
            });
        });
    </script>
@endsection
