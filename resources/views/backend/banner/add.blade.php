@extends('backend.layouts.master')

@section('content')
    <div class="page-content-wrapper ">

        <div class="container-fluid">

            <div class="row card m-b-30">
                <div class="col-sm-12">
                    <div class="float-right page-breadcrumb mt-2">
                        <a href="{{ route('banner.index') }}" class="btn btn-primary ripple px-4">
                            <i class="fa fa-angle-left"></i> Back
                        </a>
                    </div>
                    <h5 class="page-title">Create Banner</h5>

                </div>
            </div>
          
            <div class="row">
                <div class="col-md-12">

                </div>
                <div class="col-12">
                    <div class="card m-b-30">
                        <div class="card-body">

                            <!-- <h4 class="mt-0 header-title">Textual inputs</h4>
                                    <p class="text-muted m-b-30 font-14">Here are examples of <code
                                            class="highlighter-rouge">.form-control</code> applied to each
                                        textual HTML5 <code class="highlighter-rouge">&lt;input&gt;</code> <code
                                                class="highlighter-rouge">type</code>.</p> -->

                            <form action="{{ route('banner.store') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <!-- <div class="form-group row">
                                            <label for="example-text-input" class="col-sm-2 col-form-label">Title <span style="color:red">*</span></label>
                                            <div class="col-sm-10">
                                                <input class="form-control" type="text"  placeholder="Enter Title"
                                                    id="example-text-input" name="title" value="{{ old('title') }}">
                                                    @if ($errors->has('title'))
    <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $errors->first('title') }}</strong>
                                                        </span>
    @endif
                                            </div>
                                        </div> -->
                                <!-- <div class="form-group row">
                                            <label for="example-text-input" class="col-sm-2 col-form-label">Link</label>
                                            <div class="col-sm-10">
                                                <input class="form-control" type="text" required placeholder="Enter Redirect Link"
                                                    id="example-text-input" name="link" value="{{ old('link') }}">
                                            </div>
                                        </div> -->
                                <!-- <div class="form-group row">
                                            <label for="example-text-input" class="col-sm-2 col-form-label">Description <span style="color:red">*</span></label>
                                            <div class="col-sm-10">
                                                <textarea id="description" class="form-control summernote" type="text" name="description"></textarea>
                                            </div>
                                        </div>

                                         <div class="form-group row">
                                            <label for="example-text-input" class="col-sm-2 col-form-label">Url</label>
                                            <div class="col-sm-10">
                                                <input class="form-control" type="text" required placeholder="Enter Url"
                                                    id="example-text-input" name="url" value="{{ old('url') }}">
                                            </div>
                                        </div>  -->
                                <div class="form-group row">
                                    <label for="title" class="col-sm-2 col-form-label">Title</label>
                                    <div class="col-sm-10">
                                        <input class="form-control" type="text" name="title" value="{{ old('title') }}" placeholder="Enter Banner Title">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="subtitle" class="col-sm-2 col-form-label">Subtitle</label>
                                    <div class="col-sm-10">
                                        <input class="form-control" type="text" name="subtitle" value="{{ old('subtitle') }}" placeholder="Enter Banner Subtitle">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="example-text-input" class="col-sm-2 col-form-label">Image / Video <span style="color:red">*</span></label>
                                    <div class="col-sm-10">
                                        <input type="file" class="form-control" name="photo" accept="image/*,video/*" required>
                                    </div>
                                </div>

                                <!--<div class="form-group row">-->
                                <!--    <label for="example-text-input" class="col-sm-2 col-form-label">Mobile Image <span style="color:red">*</span></label>-->
                                <!-- <img src="assets/images/image.png" class="admin-image"> -->
                                <!--    <div class="col-sm-10">-->
                                <!--        <div class="input-group">-->
                                <!--            <span class="input-group-btn">-->
                                <!--              <a id="lfm_mobile" data-input="thumbnail1" data-preview="holder1" class="btn btn-primary">-->
                                <!--                <i class="fa fa-picture-o"></i> Choose -->
                                <!--              </a>-->
                                <!--            </span>-->
                                <!--            <input id="thumbnail1" class="form-control" type="text" value="{{ old('mobile_photo') }}" name="mobile_photo" >-->
                                <!--        </div>-->
                                <!--        {{-- <span class="text-note">*NOTE : Maximum image size must be 1900 x 500</span>                                                                              --}}-->

                                <!--          <div id="holder1" style="margin-top:15px;max-height:100px;"></div>-->
                                <!--    </div>-->
                                <!--</div>-->

                                <!-- {{-- <div class="form-group row">
                                <label for="example-search-input" class="col-sm-2 col-form-label">Status</label>
                                <div class="col-sm-10">
                                    <input class="form-control" type="search" Placeholder="Enter Child Category" id="example-search-input">
                                </div>
                            </div> --}} -->

                                <!-- <div class="form-group row">
                                            <label for="condition" class="col-sm-2 col-form-label">Condition</label>
                                            <div class="col-sm-10">
                                                <select class="form-control" required name='condition'>
                                                    <option value="">--Condition--</option>
                                                    <option value="banner" {{ old('condition') == 'banner' ? 'selected' : '' }}>Banner</option>

                                                    <option value="promo" {{ old('condition') == 'promo1' ? 'selected' : '' }}>Promote</option>
                                                </select>
                                            </div>
                                        </div> -->
                                <!-- <div class="form-group row">
                                            <label for="condition" class="col-sm-2 col-form-label">Type <span style="color:red">*</span></label>
                                            <div class="col-sm-10">
                                                <select class="form-control" name='type'>
                                                    <option value="">--Type--</option>
                                                    <option value="right" {{ old('condition') == 'right' ? 'selected' : '' }}>Right</option>

                                                    <option value="left" {{ old('condition') == 'left' ? 'selected' : '' }}>Left</option>
                                                </select>
                                            </div>
                                        </div> -->

                                <!--
                                        <div class="form-group row">
                                            <label for="example-text-input" class="col-sm-2 col-form-label" ><span class="text-danger"></span>Descripition</label>
                                            <div class="col-sm-10">
                                                <textarea id="elm1"name="description" value="{{ old('description') }}" placeholder="40% Off!, Free Shipping">40% Off!, Free Shipping</textarea>
                                            </div>
                                        </div> -->
                                <div class="form-group row align-items-center">
                                    <label for="status" class="col-sm-2 col-form-label">Status</label>
                                    <div class="col-sm-10">
                                        <div class="premium-switch-group">
                                            <input type="radio" name="status" id="status_active" value="active" {{ old('status') == 'active' || old('status') === null ? 'checked' : '' }}>
                                            <label for="status_active">
                                                <i class="fa fa-check-circle"></i> Active
                                            </label>
                                            
                                            <input type="radio" name="status" id="status_inactive" value="inactive" {{ old('status') == 'inactive' ? 'checked' : '' }}>
                                            <label for="status_inactive">
                                                <i class="fa fa-times-circle"></i> Inactive
                                            </label>
                                        </div>
                                    </div>
                                </div>

                                <div class="d-flex justify-content-end">
                                    <button class="btn btn-primary" type="submit">Submit</button>&nbsp;
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
@endsection
