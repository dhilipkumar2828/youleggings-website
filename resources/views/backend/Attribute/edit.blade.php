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
                {{-- <div class="col-12">
                    <div class="card m-b-30">
                        <div class="card-body">
                            <form action="{{route('attribute.store')}}" method="post">
                                @csrf
                                <div class="form-group row">
                                    <label for="status" class="col-sm-2 col-form-label">Category Name <span style="color:red">*</span></label>
                                    <div class="col-sm-10">
                                        <select class="form-control" name='cat_id' id="cat_id">
                                            <option>--Category Name--</option>
                                            @foreach (\App\Models\Category::where('is_parent', 1)->get() as $cate)
                                                <option value="{{$cate->id}}">{{$cate->title}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group row d-none" id="child_cat_div">
                                    <label for="status" class="col-sm-2 col-form-label">  Child Category Name</label>
                                    <div class="col-sm-10">
                                        <select class="form-control" name='chil_cat_id' id="chil_cat_id">

                                        </select>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="example-text-input" class="col-sm-2 col-form-label">Name</label>
                                    <div class="col-sm-10">
                                        <input class="form-control" type="text" placeholder="Enter Name"
                                            id="example-text-input" name="name" value="{{ old('name') }}">
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="example-text-input" class="col-sm-2 col-form-label">Value</label>
                                    <div class="col-sm-10">
                                        <input class="form-control" type="text" placeholder="Enter Name"
                                            id="example-text-input" name="size" value="{{ old('size') }}">
                                    </div>
                                </div>
                                <div class="form-group row">
                                <div class="d-flex">
                                    <button class="btn btn-primary" type="submit">Submit</button>&nbsp;
                                    <!-- <button class="btn btn-secondary" type="submit">Cancel</button> -->
                                </div>
                </div>
                            </form>
                        </div>
                    </div>
                </div> <!-- end col --> --}}
            </div> <!-- end row -->
        </div><!-- container fluid -->

    </div> <!-- Page content Wrapper -->

    <div class="row">
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
                                    <select class="js-example-basic-single addproduct" name="value[]" required style="width:100%;" multiple="multiple">
                                        @foreach ($attribute->value as $v)
                                            <option selected value="{{ $v }}">{{ $v }}</option>
                                        @endforeach
                                    </select>
                                    <span class="error"></span>
                                </div>
                            </div>
                            <div class="col-md-2 d-flex align-items-end">
                                <div class="form-group mb-0">
                                    <button type="submit" class="btn btn-indigo ripple px-4 py-2 font-weight-bold">Update Attribute</button>
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
                width: '100%'
            });
        });
    </script>

    <script>
        $('#cat_id').change(function() {

            var cat_id = $(this).val();
            if (cat_id != null) {
                $.ajax({
                    url: "/admin/category/" + cat_id + "/child",
                    type: "POST",
                    data: {
                        _token: "{{ csrf_token() }}",
                        cat_id: cat_id,

                    },
                    success: function(response) {
                        var html_option = "<option value=''>---Child Category---</option>";
                        // console.log(response);
                        if (response.status) {
                            $('#child_cat_div').removeClass('d-none');
                            $.each(response.data, function(id, title) {
                                html_option += "<option value='" + id + "'>" + title +
                                    "</option>"
                            });
                        } else {
                            $('#.child_cat_div').addClass('d-none');
                        }
                        $('#chil_cat_id').html(html_option);
                    }
                });
            }

        });
    </script>
@endsection
