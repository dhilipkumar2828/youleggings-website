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

                            <li class="breadcrumb-item active">Create Attribute</li>

                        </ol>

                    </div>

                    <h5 class="page-title">Create Attribute</h5>

                </div>

            </div>

            <div class="card m-b-30">
                <div class="card-body d-flex align-items-center justify-content-between">
                    <div>
                        <h4 class="card-title font-20 mt-0 mb-1">Create Attribute Group</h4>
                        <p class="text-muted mb-0">Management of product variations and attributes</p>
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

                                        <!-- <input class="form-control" type="text" placeholder="Enter Name"

                                            id="example-text-input" name="size" value="{{ old('size') }}"> -->

                                            <select class="js-example-basic-single addproduct" id="vendoritems" required placeholder="Select Products" style="width:100%;" multiple="multiple" >

                             </select>

                                    </div>

                                </div>

                                <div class="form-group row">

                                <div class="d-flex">

                                    <button class="btn btn-primary" type="submit">Submit</button>&nbsp;

                                    <button class="btn btn-secondary" id="reset" type="Reset">Cancel</button>

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
            <div class="card shadow-sm border-0">
                <div class="card-header bg-white py-3">
                    <div class="d-flex align-items-center justify-content-between">
                        <h5 class="mb-0 font-weight-bold text-primary">Create Attribute Group</h5>
                        <p class="text-muted mb-0 small">Add one or more attribute types at once</p>
                    </div>
                </div>
                <form action="{{ route('attribute.store') }}" method="POST">
                    @csrf
                    <div id="attribute" class="card-body"
                        data-mfield-options='{"section": ".group","btnAdd":"#btnAdd-1","btnRemove":".btnRemove"}'>
                        
                        <div class="col-md-12 mb-4">
                            <button type="button" id="btnAdd-1" class="btn btn-primary ripple px-4">
                                <i class="fa fa-plus-circle mr-2"></i> Add More Attributes
                            </button>
                        </div>

                        <!-- Attribute Row Template -->
                        <div class="container-fluid row group mb-4 align-items-end animate__animated animate__fadeIn">
                            <div class="col-md-5">
                                <div class="form-group mb-0">
                                    <label class="font-weight-bold">Attribute Type <span class="text-danger">*</span></label>
                                    <input class="form-control" name="attribute_type[0]" type="text" required
                                        placeholder="e.g. Size, Color">
                                </div>
                            </div>
                            <div class="col-md-5">
                                <div class="form-group mb-0">
                                    <label class="font-weight-bold">Attribute Values <span class="text-danger">*</span></label>
                                    <select class="js-example-basic-single addproduct" name="value[0][]" required
                                        style="width:100%;" multiple="multiple">
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <button type="button" class="btn btn-danger btnRemove ripple w-100">
                                    <i class="fa fa-trash mr-1"></i> Remove
                                </button>
                            </div>
                        </div>
                    </div>

                    <div class="card-footer bg-light border-top-0 d-flex justify-content-end py-3">
                        <button type="submit" class="btn btn-indigo ripple px-5 py-2 font-weight-bold">
                            <i class="fa fa-save mr-2"></i> Save Attributes
                        </button>
                    </div>
                </form>
            </div>
        </div> <!-- end col -->
    </div>

@endsection

@section('scripts')

    <script>
        $(document).ready(function() {
            // Function to initialize Select2
            function initSelect2(element) {
                $(element).select2({
                    tags: true,
                    placeholder: "Add values (press enter)",
                    width: '100%',
                    containerCssClass: 'select2-premium'
                });
            }

            // Update indices for all rows
            function updateIndices() {
                $('.group').each(function(index) {
                    $(this).find('input[name*="attribute_type"]').attr('name', 'attribute_type[' + index + ']');
                    var $select = $(this).find('select[name*="value"]');
                    $select.attr('name', 'value[' + index + '][]');
                });
            }

            // Initial load
            $('.js-example-basic-single').each(function() {
                initSelect2(this);
            });

            // Handle Multifield logic
            $('#attribute').multifield({
                section: '.group',
                btnAdd: '#btnAdd-1',
                btnRemove: '.btnRemove'
            });

            // Re-initialize Select2 on newly added rows
            $(document).on('click', '#btnAdd-1', function() {
                setTimeout(function() {
                    var $lastRow = $('.group').last();
                    
                    // Cleanup any Select2 artifacts from cloning
                    $lastRow.find('.select2-container').remove();
                    $lastRow.find('.js-example-basic-single').each(function() {
                        $(this).removeClass('select2-hidden-accessible');
                        $(this).removeAttr('data-select2-id');
                        $(this).find('option').removeAttr('data-select2-id');
                        $(this).val(null).trigger('change');
                        initSelect2(this);
                    });
                    
                    updateIndices();
                    
                    // Add animation
                    $lastRow.addClass('animate__animated animate__fadeInUp');
                }, 50);
            });

            $(document).on('click', '.btnRemove', function() {
                // Indices need update AFTER removal
                setTimeout(updateIndices, 500);
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
