@extends('backend.layouts.master')

@section('content')
    <div class="page-content-wrapper ">

        <div class="container-fluid">

            <div class="row">
                <div class="col-sm-12">
                    <div class="float-right page-breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a>Appearence</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('categorytag.index') }}">Category Tag</a></li>
                            <li class="breadcrumb-item active">Edit Category Tag</li>
                        </ol>
                    </div>
                    <h5 class="page-title">Appearence</h5>

                </div>
            </div>
            <div class="card m-b-30 card-body">
                <h4 class="card-title font-20 mt-0">Edit Category Tag</h4>
                <a href="{{ route('categorytag.index') }}" id="add-btn" style="color: #ffffff;"><i
                        class="fa fa-angle-left" aria-hidden="true"></i> Back</a>

            </div>

            <div class="row">
                <div class="col-md-12">

                </div>
                <div class="col-12">
                    <div class="card m-b-30">
                        <div class="card-body">
                            <form action="{{ route('categorytag.update', $categorytag->id) }}" method="post">
                                @csrf
                                @method('patch')

                                <div class="form-group row">
                                    <label for="cate_tag" class="col-sm-2 col-form-label">Tag <span
                                            style="color:red">*</span></label>
                                    <div class="col-sm-10">
                                        <select id="cate_tag" name="cate_tag" class="form-control">
                                            <option value="0" selected>-- 0 --</option>
                                            <option value="FC" {{ $categorytag->cate_tag == 'FC' ? 'selected' : '' }}>FC
                                            </option>
                                            <option value="PP" {{ $categorytag->cate_tag == 'PP' ? 'selected' : '' }}>PP
                                            </option>

                                        </select>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="cate_tag" class="col-sm-2 col-form-label">Category</label>
                                    <div class="col-sm-10">
                                        <select class="form-control" name="category" id="category">
                                            <option value="0" selected>-- 0 --</option>
                                            <option value="">Select Category</option>
                                            @foreach ($categories as $category)
                                                <option value="{{ $category->slug }}"
                                                    {{ $category->slug == old('category', $categorytag->link) ? 'selected' : '' }}
                                                    data-image="{{ $category->photo }}">
                                                    {{ $category->title }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="example-text-input" class="col-sm-2 col-form-label">Image</label>
                                    <!-- <img src="assets/images/image.png" class="admin-image"> -->
                                    <div class="col-sm-10">
                                        <div class="input-group d-flex align-items-center"
                                            style="border: 1px dashed #ced4da; border-radius: 8px; padding: 0 5px; background: #fff; height: 45px;">
                                            <span class="input-group-btn" style="margin-right:0;">
                                                <a id="lfm" data-input="thumbnail" data-preview="holder"
                                                    class="btn btn-primary ripple"
                                                    style="border-radius: 6px; padding: 6px 12px;">
                                                    <i class="fa fa-picture-o"></i> Choose
                                                </a>
                                            </span>
                                            <input id="thumbnail" required class="form-control" type="text"
                                                value="{{ $categorytag->photo }}" name="photo"
                                                style="border: none !important; box-shadow: none !important; background: transparent !important; margin-left: 10px; height: 100% !important; padding: 0;"
                                                placeholder="Select an image...">
                                        </div>
                                        <div id="holder" style="margin-top:15px;max-height:100px;"><img
                                                src="{{ $categorytag->photo }}"
                                                alt="promo image"style="max-height: 90px;max-width:120px">
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="status" class="col-sm-2 col-form-label">Status</label>
                                    <div class="col-sm-10">
                                        <select class="form-control" name='status' value="{{ $categorytag->status }}">
                                            <option value="">--Status--</option>
                                            <option value="active"
                                                {{ $categorytag->status == 'active' ? 'selected' : '' }}>Active</option>

                                            <option value="inactive"
                                                {{ $categorytag->status == 'inactive' ? 'selected' : '' }}>Inactive
                                            </option>
                                        </select>
                                    </div>
                                </div>
                                <div class="d-flex">
                                    <button class="btn btn-primary" type="submit">Update</button>&nbsp;
                                    <!-- <button class="btn btn-secondary" type="Reset">Cancel</button> -->
                                </div>
                            </form>
                        </div>
                    </div>
                </div> <!-- end col -->
            </div> <!-- end row -->
        </div><!-- container fluid -->

    </div> <!-- Page content Wrapper -->
@endsection
@section('scripts')
    <script src="{{ asset('public/vendor/laravel-filemanager/js/stand-alone-button.js') }}"></script>

    <script>
        $('#lfm').filemanager('image');
        $('#lfm_mobile').filemanager('image');
    </script>
    <script>
        // Function to fetch categories based on is_parent value
        function fetchCategories(isParent) {
            fetch(`/get-categories/${isParent}`)
                .then(response => response.json())
                .then(data => {
                    var categorySelect = document.getElementById('category');

                    // Clear all categories except the placeholder
                    categorySelect.innerHTML = '<option value="">Select Category</option>';

                    // Populate the category dropdown with fetched categories
                    data.categories.forEach(function(category) {
                        var option = document.createElement('option');
                        option.value = category.slug;
                        option.textContent = category.title;

                        // If the category matches the previously selected category, mark it as selected
                        if (category.slug === '{{ $categorytag->link }}') {
                            option.selected = true;
                        }

                        categorySelect.appendChild(option);
                    });
                })
                .catch(error => console.error('Error fetching categories:', error));
        }

        // On page load, fetch categories based on the selected cate_tag
        document.addEventListener('DOMContentLoaded', function() {
            var selectedTag = document.getElementById('cate_tag').value; // Get the current cate_tag value

            // If cate_tag is FC, fetch categories where is_parent = 1, otherwise fetch where is_parent = 0
            var isParent = selectedTag === 'FC' ? 'FC' : 'PP';
            fetchCategories(isParent);

            // Listen for changes to cate_tag and fetch categories accordingly
            document.getElementById('cate_tag').addEventListener('change', function() {
                var selectedTag = this.value; // Get the selected value (FC or PP)
                var isParent = selectedTag === 'FC' ? 'FC' : 'PP'; // Send 'FC' or 'PP' to the backend
                fetchCategories(isParent); // Fetch categories based on the selected tag
            });
        });
    </script>

    <script>
        $(document).ready(function() {
            if ($("#elm1").length > 0) {
                tinymce.init({
                    selector: "textarea#elm1",
                    theme: "modern",
                    height: 300,
                    plugins: [
                        "advlist autolink link image lists charmap print preview hr anchor pagebreak spellchecker",
                        "searchreplace wordcount visualblocks visualchars code fullscreen insertdatetime media nonbreaking",
                        "save table contextmenu directionality emoticons template paste textcolor"
                    ],
                    toolbar: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | l      ink image | print preview media fullpage | forecolor backcolor emoticons",
                    style_formats: [{
                            title: 'Bold text',
                            inline: 'b'
                        },
                        {
                            title: 'Red text',
                            inline: 'span',
                            styles: {
                                color: '#ff0000'
                            }
                        },
                        {
                            title: 'Red header',
                            block: 'h1',
                            styles: {
                                color: '#ff0000'
                            }
                        },
                        {
                            title: 'Example 1',
                            inline: 'span',
                            classes: 'example1'
                        },
                        {
                            title: 'Example 2',
                            inline: 'span',
                            classes: 'example2'
                        },
                        {
                            title: 'Table styles'
                        },
                        {
                            title: 'Table row 1',
                            selector: 'tr',
                            classes: 'tablerow1'
                        }
                    ]
                });
            }
        });
    </script>
@endsection
