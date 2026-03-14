@extends('backend.layouts.master')

@section('content')
    <div class="page-content-wrapper ">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-12">
                    <div class="float-right page-breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a>Settings</a></li>
                            <li class="breadcrumb-item active">General Settings</li>
                        </ol>
                    </div>
                    <h5 class="page-title">General Settings</h5>
                </div>
            </div>
            
            <div class="row">
                <div class="col-12">
                    <div class="card m-b-30">
                        <div class="card-body">
                            @include('backend.layouts.notification')

                            <form action="{{ route('settings.update') }}" method="post">
                                @csrf
                                @method('patch')

                                <h4 class="mt-0 header-title">Header Settings</h4>
                                <div class="form-group row">
                                    <label for="logo" class="col-sm-2 col-form-label">Logo</label>
                                    <div class="col-sm-10">
                                        <div class="input-group d-flex align-items-center"
                                            style="border: 1px dashed #ced4da; border-radius: 8px; padding: 0 5px; background: #fff; height: 45px;">
                                            <span class="input-group-btn" style="margin-right:0;">
                                                <a id="lfm" data-input="logo" data-preview="holder"
                                                    class="btn btn-primary ripple"
                                                    style="border-radius: 6px; padding: 6px 12px;">
                                                    <i class="fa fa-picture-o"></i> Choose
                                                </a>
                                            </span>
                                            <input id="logo" class="form-control" type="text"
                                                value="{{ $setting->logo ?? '' }}" name="logo"
                                                style="border: none !important; box-shadow: none !important; background: transparent !important; margin-left: 10px; height: 100% !important; padding: 0;"
                                                placeholder="Select logo image...">
                                        </div>
                                        <div id="holder" style="margin-top:15px;max-height:100px;">
                                            @if($setting && $setting->logo)
                                                <img src="{{ asset($setting->logo) }}" style="max-height: 90px;max-width:120px">
                                            @endif
                                        </div>
                                    </div>
                                </div>

                                <h4 class="mt-4 header-title">Top Bar Scrolling Text</h4>
                                @for ($i = 1; $i <= 4; $i++)
                                    <div class="form-group row">
                                        <label for="top_bar_{{ $i }}" class="col-sm-2 col-form-label">Text {{ $i }}</label>
                                        <div class="col-sm-10">
                                            <input class="form-control" type="text" name="top_bar_{{ $i }}" value="{{ $setting->{"top_bar_{$i}"} ?? '' }}">
                                        </div>
                                    </div>
                                @endfor

                                <h4 class="mt-4 header-title">Contact Information</h4>
                                <div class="form-group row">
                                    <label for="email" class="col-sm-2 col-form-label">Email</label>
                                    <div class="col-sm-10">
                                        <input class="form-control" type="email" name="email" value="{{ $setting->email ?? '' }}">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="phone" class="col-sm-2 col-form-label">Phone</label>
                                    <div class="col-sm-10">
                                        <input class="form-control" type="text" name="phone" value="{{ $setting->phone ?? '' }}">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="address" class="col-sm-2 col-form-label">Address</label>
                                    <div class="col-sm-10">
                                        <textarea class="form-control" name="address" rows="3">{{ $setting->address ?? '' }}</textarea>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="google_map" class="col-sm-2 col-form-label">Google Maps Link</label>
                                    <div class="col-sm-10">
                                        <textarea class="form-control" name="google_map" rows="3">{{ $setting->google_map ?? '' }}</textarea>
                                    </div>
                                </div>

                                <h4 class="mt-4 header-title">Footer Settings</h4>
                                <div class="form-group row">
                                    <label for="footer_description" class="col-sm-2 col-form-label">Footer Description</label>
                                    <div class="col-sm-10">
                                        <textarea class="form-control" name="footer_description" rows="3">{{ $setting->footer_description ?? '' }}</textarea>
                                    </div>
                                </div>

                                <h4 class="mt-4 header-title">Social Links</h4>
                                <div class="form-group row">
                                    <label for="facebook_link" class="col-sm-2 col-form-label">Facebook</label>
                                    <div class="col-sm-10">
                                        <input class="form-control" type="text" name="facebook_link" value="{{ $setting->facebook_link ?? '' }}">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="instagram_link" class="col-sm-2 col-form-label">Instagram</label>
                                    <div class="col-sm-10">
                                        <input class="form-control" type="text" name="instagram_link" value="{{ $setting->instagram_link ?? '' }}">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="twitter_link" class="col-sm-2 col-form-label">Twitter</label>
                                    <div class="col-sm-10">
                                        <input class="form-control" type="text" name="twitter_link" value="{{ $setting->twitter_link ?? '' }}">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="youtube_link" class="col-sm-2 col-form-label">Youtube</label>
                                    <div class="col-sm-10">
                                        <input class="form-control" type="text" name="youtube_link" value="{{ $setting->youtube_link ?? '' }}">
                                    </div>
                                </div>

                                <div class="mt-4 float-right">
                                    <button class="btn btn-primary" type="submit">Update Settings</button>
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
    <script>
        var lfm_route = (typeof route_prefix !== 'undefined') ? route_prefix : ($('meta[name="route_prefix"]').attr('content') || '/laravel-filemanager');
        $('#lfm').filemanager('image', {prefix: lfm_route});
    </script>
@endsection
