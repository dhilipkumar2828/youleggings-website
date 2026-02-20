@extends('backend.layouts.master')

@section('content')
<div class="page-content-wrapper ">
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12">
                <div class="float-right page-breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="#">Appearance</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('flash-deals.index') }}">Flash Deals</a></li>
                        <li class="breadcrumb-item active">Edit Flash Deal</li>
                    </ol>
                </div>
                <h5 class="page-title">Edit Flash Deal</h5>
            </div>
        </div>

        <div class="card m-b-30 card-body">
            <h4 class="card-title font-20 mt-0">Edit Flash Deal</h4>
            <a href="{{ route('flash-deals.index') }}" class="btn btn-primary text-white"><i class="fa fa-arrow-left"></i> Back</a>
        </div>

        <div class="row">
            <div class="col-12">
                <div class="card m-b-30">
                    <div class="card-body">
                        <form action="{{ route('flash-deals.update', $deal->id) }}" method="post" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            
                            <!-- Left Section -->
                            <h4 class="mt-0 header-title">Left Banner Section</h4>
                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label">Title</label>
                                <div class="col-sm-10">
                                    <input class="form-control" type="text" name="title" value="{{ $deal->title }}">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label">Subtitle</label>
                                <div class="col-sm-10">
                                    <input class="form-control" type="text" name="subtitle" value="{{ $deal->subtitle }}">
                                </div>
                            </div>
                             <div class="form-group row">
                                <label class="col-sm-2 col-form-label">Description</label>
                                <div class="col-sm-10">
                                    <textarea class="summernote" name="description">{{ $deal->description }}</textarea>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label">Banner Images (Left Background)</label>
                                <div class="col-sm-10">
                                    <div class="input-group">
                                        <span class="input-group-btn">
                                            <a id="lfm" data-input="thumbnail" data-preview="holder" class="btn btn-primary text-white">
                                                <i class="fa fa-picture-o"></i> Choose
                                            </a>
                                        </span>
                                        <input id="thumbnail" class="form-control" type="text" name="banner_image" value="{{ $deal->banner_image }}">
                                    </div>
                                    <div id="holder" style="margin-top:15px;max-height:100px;">
                                        @if($deal->banner_image)
                                            @php
                                                $images = explode(',', $deal->banner_image);
                                            @endphp
                                            @foreach($images as $img)
                                                <img src="{{ asset($img) }}" style="height: 5rem; margin-right: 10px;">
                                            @endforeach
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <hr>

                            <!-- Right Section -->
                            <h4 class="mt-0 header-title">Right Deal Section</h4>
                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label">Deal Title</label>
                                <div class="col-sm-10">
                                    <input class="form-control" type="text" name="deal_title" value="{{ $deal->deal_title }}">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label">Discount Value</label>
                                <div class="col-sm-10">
                                    <input class="form-control" type="text" name="discount_value" value="{{ $deal->discount_value }}">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label">Deal End Date</label>
                                <div class="col-sm-10">
                                    <input class="form-control" type="datetime-local" name="deal_end_date" value="{{ date('Y-m-d\TH:i', strtotime($deal->deal_end_date)) }}">
                                </div>
                            </div>
                             <div class="form-group row">
                                <label class="col-sm-2 col-form-label">Deal Image (Right Side)</label>
                                <div class="col-sm-10">
                                    <div class="input-group">
                                        <span class="input-group-btn">
                                            <a id="lfm1" data-input="thumbnail1" data-preview="holder1" class="btn btn-primary text-white">
                                                <i class="fa fa-picture-o"></i> Choose
                                            </a>
                                        </span>
                                        <input id="thumbnail1" class="form-control" type="text" name="deal_image_1" value="{{ $deal->deal_image_1 }}">
                                    </div>
                                    <div id="holder1" style="margin-top:15px;max-height:100px;">
                                        @if($deal->deal_image_1)
                                            @php
                                                $images = explode(',', $deal->deal_image_1);
                                            @endphp
                                            @foreach($images as $img)
                                                <img src="{{ asset($img) }}" style="height: 5rem; margin-right: 10px;">
                                            @endforeach
                                        @endif
                                    </div>
                                </div>
                            </div>


                             <div class="form-group row">
                                <label class="col-sm-2 col-form-label">Status</label>
                                <div class="col-sm-10">
                                    <select class="form-control" name="status">
                                        <option value="active" {{ $deal->status == 'active' ? 'selected' : '' }}>Active</option>
                                        <option value="inactive" {{ $deal->status == 'inactive' ? 'selected' : '' }}>Inactive</option>
                                    </select>
                                </div>
                            </div>
                            
                            <div class="form-group row m-t-20">
                                <div class="col-12 text-right">
                                    <button class="btn btn-primary w-md waves-effect waves-light" type="submit">Update Flash Deal</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script src="{{ asset('public/vendor/laravel-filemanager/js/stand-alone-button.js') }}"></script>
<script src="{{ asset('assets/plugins/summernote/summernote-bs4.min.js') }}"></script>
<script>
    $('#lfm').filemanager('image');
    $('#lfm1').filemanager('image');

    $('.summernote').summernote({
        height: 150
    });
</script>
@endsection
