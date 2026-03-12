@extends('backend.layouts.master')

@section('content')
    <div class="page-content-wrapper ">

        <div class="container-fluid">

            <div class="row">
                <div class="col-sm-12">
                    <div class="float-right page-breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a>Appearence</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('banner.index') }}">Banner</a></li>
                            <li class="breadcrumb-item active">Edit Banner</li>
                        </ol>
                    </div>
                    <h5 class="page-title">Appearence</h5>

                </div>
            </div>
            <div class="card m-b-30 card-body">
                <h4 class="card-title font-20 mt-0">Edit Banner</h4>
                <a href="{{ route('banner.index') }}" id="add-btn" style="color: #ffffff;"><i class="fa fa-angle-left"
                        aria-hidden="true"></i> Back</a>

            </div>
            <div class="row">

                <div class="col-12">
                    <div class="card m-b-30">
                        <div class="card-body">

                            <!-- <h4 class="mt-0 header-title">Textual inputs</h4>
                                    <p class="text-muted m-b-30 font-14">Here are examples of <code
                                            class="highlighter-rouge">.form-control</code> applied to each
                                        textual HTML5 <code class="highlighter-rouge">&lt;input&gt;</code> <code
                                                class="highlighter-rouge">type</code>.</p> -->

                            <form action="{{ route('banner.update', $banner->id) }}" method="post" enctype="multipart/form-data">
                                @csrf
                                @method('patch')

                                <!-- {{-- <div class="form-group row">
                                    <label for="example-text-input" class="col-sm-2 col-form-label">Image <span style="color:red">*</span></label>
                                    <div class="col-sm-10">
                                        <input id="thumbnail" class="form-control" type="text" name="filepath">
                                    </div>
                                </div> --}} -->

                                <div class="form-group row">
                                    <label for="title" class="col-sm-2 col-form-label">Title</label>
                                    <div class="col-sm-10">
                                        <input class="form-control" type="text" name="title" value="{{ $banner->title }}" placeholder="Enter Banner Title">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="subtitle" class="col-sm-2 col-form-label">Subtitle</label>
                                    <div class="col-sm-10">
                                        <input class="form-control" type="text" name="subtitle" value="{{ $banner->subtitle }}" placeholder="Enter Banner Subtitle">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="example-text-input" class="col-sm-2 col-form-label">Image / Video </label>
                                    <div class="col-sm-10">
                                        <input type="file" class="form-control" name="photo" accept="image/*,video/*">
                                        <small class="text-muted">Leave blank if you don't want to change the file.</small>
                                        <div id="holder" style="margin-top:15px;max-height:100px;">
                                            @if($banner->photo && preg_match('/\.(mp4|mov|ogg|qt)$/i', $banner->photo))
                                                <video src="{{ $banner->photo }}" style="max-height: 90px;max-width:120px" controls></video>
                                            @else
                                                <img src="{{ url($banner->photo) }}" alt="promo image" style="max-height: 90px;max-width:120px">
                                            @endif
                                        </div>
                                    </div>
                                </div>

                                <!--<div class="form-group row">-->
                                <!--                                   <label for="example-text-input" class="col-sm-2 col-form-label">Mobile Image <span style="color:red">*</span></label>-->
                                <!-- <img src="assets/images/image.png" class="admin-image"> -->
                                <!--                                   <div class="col-sm-10">-->
                                <!--                                       <div class="input-group">-->
                                <!--                                           <span class="input-group-btn">-->
                                <!--                                             <a id="lfm_mobile" data-input="thumbnail1" data-preview="holder1" class="btn btn-primary">-->
                                <!--                                               <i class="fa fa-picture-o"></i> Choose-->
                                <!--                                             </a>-->
                                <!--                                           </span>-->
                                <!--                                           <input id="thumbnail1" class="form-control" required type="text" name="mobile_photo" value="{{ $banner->mobile_photo }}">-->
                                <!--                                         </div>-->
                                <!--                                         <div id="holder1" style="margin-top:15px;max-height:100px;"><img src="{{ $banner->mobile_photo }}" alt="promo image"style="max-height: 90px;max-width:120px">-->
                                <!--                                         </div>-->
                                <!--                                       </div>-->
                                <!--                                   </div>-->

                                <!-- <div class="form-group row">
                                            <label for="condition" class="col-sm-2 col-form-label"> Condition <span style="color:red">*</span></label>
                                            <div class="col-sm-10">
                                                <select class="form-control" required name='condition'>
                                                    <option>--Condition--</option>
                                                    <option value="banner" {{ $banner->condition == 'banner' ? 'selected' : '' }}>Banner</option>

                                                    <option value="promo" {{ $banner->condition == 'promo' ? 'selected' : '' }}>Promote</option>
                                                </select>
                                            </div>
                                        </div> -->

                                <!-- <div class="form-group row">
                                            <label for="condition" class="col-sm-2 col-form-label"> Type <span style="color:red">*</span></label>
                                            <div class="col-sm-10">
                                                <select class="form-control" name='type'>
                                                    <option>--Type--</option>
                                                    <option value="right" {{ $banner->type == 'right' ? 'selected' : '' }}>Right</option>

                                                    <option value="left" {{ $banner->type == 'left' ? 'selected' : '' }}>Left</option>
                                                </select>
                                            </div>
                                        </div> -->

                                {{--
                                <div class="form-group row">
                                    <label for="example-text-input" class="col-sm-2 col-form-label" <span class="text-danger">*</span>>Condition</label>
                                    <!-- <img src="assets/images/image.png" class="admin-image"> -->
                                    <div class="col-sm-10">
                                        <input type="text" id="myFile" name="filename">
                                    </div>
                                </div> --}}

                                <div class="form-group row">
                                    <label for="status" class="col-sm-2 col-form-label">Status</label>
                                    <div class="col-sm-10">
                                        <select class="form-control" required name='status'
                                            value="{{ $banner->status }}">
                                            <option value="">--Status--</option>
                                            <option value="active" {{ $banner->status == 'active' ? 'selected' : '' }}>
                                                Active</option>

                                            <option value="inactive"
                                                {{ $banner->status == 'inactive' ? 'selected' : '' }}>Inactive</option>

                                        </select>
                                        @if ($errors)
                                            <span class="text-danger">{{ $errors->first('status') }}</span>
                                        @endif
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

    <script>
        var lfm_route = (typeof route_prefix !== 'undefined') ? route_prefix : ($('meta[name="route_prefix"]').attr('content') || '/laravel-filemanager');
        $('#lfm').filemanager('file', {prefix: lfm_route});
        $('#lfm_mobile').filemanager('file', {prefix: lfm_route});
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
