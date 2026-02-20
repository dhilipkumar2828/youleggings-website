@extends('backend.layouts.master')

@section('content')

    <div class="page-content-wrapper ">

        <div class="container-fluid">

            <div class="row">

                <div class="col-sm-12">

                    <div class="float-right page-breadcrumb">

                        <ol class="breadcrumb">

                            <li class="breadcrumb-item"><a href="#">User Role</a></li>

                            <li class="breadcrumb-item">User List</li>

                            <li class="breadcrumb-item active">Edit User </li>

                        </ol>

                    </div>

                    <h5 class="page-title">User Role </h5>

                </div>

            </div>

            <div class="card m-b-30 card-body">

                <h4 class="card-title font-20 mt-0">User Role </h4>

                <a href="{{ url('roleview') }}" id="add-btn" style="color: #ffffff;"><i class="fa fa-angle-left"
                        aria-hidden="true"></i> Back</a>

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

                </div>

                <div class="col-12">

                    <div class="card m-b-30">

                        <div class="card-body">

                            <form action="{{ url('roleupdate') . '/' . $roles->id }}" method="post">

                                @csrf

                                <div class="form-group row">

                                    <label for="example-text-input" class="col-sm-2 col-form-label">Role Name <span
                                            style="color:red">*</span></label>

                                    <div class="col-sm-10">

                                        <input class="form-control" type="text" required placeholder="Enter Name"
                                            id="example-text-input" name="role" value="{{ $roles->name }}">

                                    </div>

                                </div>

                                <div>

                                    <label for="">Permissions</label><br>

                                    <span class="select-all">

                                        <input type="checkbox" id="select-all">

                                        <label for="">Select All</label>

                                    </span>

                                </div>

                                <hr>

                                @if ($permissionGroups->count())
                                    <div class="row">

                                        @foreach ($permissionGroups as $permissionGroup)
                                            <div class="col-md-4">

                                                <div class="form-check">

                                                    <div class="roles-head">

                                                        <input type="checkbox" data-id="{{ $permissionGroup->id }}"
                                                            id="gp{{ $permissionGroup->id }}" class="groupcheck">

                                                        <label for="">
                                                            <h4>{{ $permissionGroup->name }}</h4>
                                                        </label>

                                                    </div>

                                                    <div class="roles-body">

                                                        @if ($permissionGroup->permissions->count())
                                                            @php $i=0; @endphp

                                                            @foreach ($permissionGroup->permissions as $permission)
                                                                <div class="col-sm-10">

                                                                    <input
                                                                        @if (in_array($permission->id, $roles->permissions->pluck('id')->toArray())) checked

                                                                        {{ $i++ }} @endif
                                                                        value="{{ $permission->id }}" name="permission[]"
                                                                        class="form-check-input pgroup{{ $permissionGroup->id }}"
                                                                        type="checkbox">

                                                                    <label class="form-check-label" for="defaultCheck1">

                                                                        {{ $permission->name }}

                                                                    </label><br>

                                                                </div>
                                                            @endforeach

                                                            @if ($i == $permissionGroup->permissions->count())
                                                                <script>
                                                                    document.getElementById('gp' + {{ $permissionGroup->id }}).checked = true;
                                                                </script>
                                                            @endif
                                                        @endif

                                                    </div>

                                                </div>

                                            </div>
                                        @endforeach

                                    </div><br>
                                @endif

                                <div class="d-flex">

                                    <button class="btn btn-primary" type="submit">Update</button>&nbsp;

                                    <button class="btn btn-secondary" type="Reset">Cancel</button>

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
    </script>

    <script>
        $(document).ready(function() {

            $('#select-all').click(function() {

                var checked = this.checked;

                $('input[type="checkbox"]').each(function() {

                    this.checked = checked;

                });

            })

            $('.groupcheck').click(function() {

                let id = $(this).data('id');

                if (this.checked == true) {

                    $('.pgroup' + id).prop('checked', true);

                } else {

                    $('.pgroup' + id).prop('checked', false);

                }

            });

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

                    style_formats: [

                        {
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
