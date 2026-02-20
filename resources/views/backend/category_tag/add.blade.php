@extends('backend.layouts.master')

@section('content')
    <style>
        .category-field {
            display: none;
        }
    </style>

    <div class="page-content-wrapper ">

        <div class="container-fluid">

            <div class="row">
                <div class="col-sm-12">
                    <div class="float-right page-breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a>Appearence</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('categorytag.index') }}">Categoty Tag</a></li>
                            <li class="breadcrumb-item active">Create Banner</li>
                        </ol>
                    </div>
                    <h5 class="page-title">Appearence</h5>

                </div>
            </div>
            <div class="card m-b-30 card-body">
                <h4 class="card-title font-20 mt-0">Create Categoty Tag</h4>
                <a href="{{ route('categorytag.index') }}" id="add-btn" style="color: #ffffff;"><i
                        class="fa fa-angle-left" aria-hidden="true"></i> Back</a>

            </div>
            <div class="row">
                <div class="col-md-12">

                </div>
                <div class="col-12">
                    <div class="card m-b-30">
                        <div class="card-body">

                            <form action="{{ route('categorytag.store') }}" method="POST">
                                @csrf

                                <div class="form-group row">
                                    <label for="cate_tag" class="col-sm-2 col-form-label">Tag <span
                                            style="color:red">*</span></label>
                                    <div class="col-sm-10">
                                        <select id="cate_tag" name="cate_tag" class="form-control">
                                            <option value="" selected>-- 0 --</option>
                                            <option value="FC">FC</option>
                                            <option value="PP">PP</option>
                                            <!-- Add more options as needed -->
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group row" id="category-field" class="category-field">
                                    <label for="example-text-input" class="col-sm-2 col-form-label">Category</label>
                                    <div class="col-sm-10">
                                        <select class="form-control" name="category" id="category" required>
                                            <option value="">Select Category</option>
                                            <!-- Categories will be loaded dynamically based on the selected tag -->
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="example-text-input" class="col-sm-2 col-form-label">Image <span
                                            style="color:red">*</span></label>
                                    <!-- <img src="assets/images/image.png" class="admin-image"> -->
                                    <div class="col-sm-10">
                                        <div class="input-group"
                                            style="border: 1px dashed #ced4da; border-radius: 8px; padding: 5px; background: #fff;">
                                            <span class="input-group-btn" style="margin-right:0;">
                                                <a id="lfm" data-input="thumbnail" data-preview="holder"
                                                    class="btn btn-primary ripple"
                                                    style="border-radius: 6px; padding: 8px 15px;">
                                                    <i class="fa fa-picture-o"></i> Choose
                                                </a>
                                            </span>
                                            <input id="thumbnail" class="form-control" type="text"
                                                value=\"{{ old('photo') }}\" name=\"photo\"
                                                style="border: none !important; box-shadow: none !important; background: transparent !important; margin-left: 10px; height: 100% !important; padding-top: 10px;"
                                                placeholder="Select an image...">
                                        </div>
                                        {{-- <span class="text-note">*NOTE : Maximum image size must be 1900 x 500</span>                                                                              --}}

                                        <div id="holder" style="margin-top:15px;max-height:100px;"></div>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="status" class="col-sm-2 col-form-label">Status</label>
                                    <div class="col-sm-10">
                                        <select class="form-control" name='status' required>
                                            <option value="">--Status--</option>
                                            <option value="active" {{ old('status') == 'active' ? 'selected' : '' }}>Active
                                            </option>

                                            <option value="inactive" {{ old('status') == 'inactive' ? 'selected' : '' }}>
                                                Inactive</option>

                                        </select>

                                    </div>

                                </div>

                                <div class="d-flex">
                                    <button class="btn btn-primary" type="submit">Submit</button>&nbsp;
                                    <button class="btn btn-secondary" id="reset" type="Reset">Cancel</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div> <!-- end col -->
            </div> <!-- end row -->
        </div><!-- container fluid -->

    </div> <!-- Page content Wrapper -->

    <script>
        document.getElementById('cate_tag').addEventListener('change', function() {
            var tag = this.value;
            var categoryField = document.getElementById('category-field');
            var holder = document.getElementById('holder');

            holder.innerHTML = ''; // Clear the image preview

            if (tag === 'FC' || tag === 'PP') {

                categoryField.classList.remove('d-none'); // Show category field

                fetchCategories(tag === 'FC' ? 'FC' : 'PP');

            } else {

                categoryField.classList.add('d-none'); // Hide category field

            }

        });

        //     if (tag === 'FC') {
        //         categoryField.style.display = 'block';
        //         fetchCategories('FC'); // Fetch all categories for FC
        //     } else if (tag === 'PP') {
        //         categoryField.style.display = 'block';
        //         fetchCategories('PP'); // Fetch only is_parent = 0 categories for PP
        //     } else {
        //         categoryField.style.display = 'none';
        //     }
        // });

        function fetchCategories(tag) {
            fetch('/get-categories/' + tag)
                .then(response => response.json())
                .then(data => {
                    var categorySelect = document.getElementById('category');
                    categorySelect.innerHTML = '<option value="">Select Category</option>';

                    data.categories.forEach(function(category) {
                        var option = document.createElement('option');
                        option.value = category.slug;
                        option.textContent = category.title;
                        option.dataset.image = category.photo; // Store image path in data attribute
                        categorySelect.appendChild(option);
                    });
                })
                .catch(error => console.error('Error fetching categories:', error));
        }

        // document.getElementById('category').addEventListener('change', function() {
        //     var tag = document.getElementById('cate_tag').value;
        //     var selectedCategory = this.options[this.selectedIndex];
        //     var categoryImage = selectedCategory.dataset.image;
        //     var holder = document.getElementById('holder');
        //     var thumbnailInput = document.getElementById('thumbnail');

        //     holder.innerHTML = '';

        //     if (tag === 'PP' && categoryImage) {
        //         holder.innerHTML = `<img src="${categoryImage}" class="img-fluid" alt="Category Image" style="max-width: 90px; height: auto;">`;

        //         thumbnailInput.value = categoryImage;
        //         thumbnailInput.readOnly = true;

        //     } else {
        //         thumbnailInput.value = '';
        //         thumbnailInput.readOnly = false;
        //     }
        // });
    </script>
@endsection
