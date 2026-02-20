@extends('backend.layouts.master')

@section('content')
    <div class="page-content-wrapper ">

        <div class="container-fluid">

            <div class="row">

                <div class="col-sm-12">

                    <div class="float-right page-breadcrumb">

                        <ol class="breadcrumb">

                            <li class="breadcrumb-item"><a>Appearence</a></li>

                            <li class="breadcrumb-item"><a href="{{ route('youtube.index') }}">Youtube</a></li>

                            <li class="breadcrumb-item active">Create Youtube</li>

                        </ol>

                    </div>

                    <h5 class="page-title">Youtube</h5>

                </div>

            </div>

            <div class="card m-b-30 card-body">

                <h4 class="card-title font-20 mt-0">Create Youtube</h4>

                <a href="{{ route('youtube.index') }}" id="add-btn" style="color: #ffffff;"><i class="fa fa-angle-left"
                        aria-hidden="true"></i> Back</a>

            </div>

            <div class="row">

                <div class="col-md-12">

                </div>

                <div class="col-12">

                    <div class="card m-b-30">

                        <div class="card-body">

                            <form action="{{ route('youtube.store') }}" method="POST">

                                @csrf

                                <div class="form-group row">

                                    <label for="example-text-input" class="col-sm-2 col-form-label">Image <span
                                            style="color:red">*</span></label>

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
                                            <input id="thumbnail" required class="form-control" type="text"
                                                value=\"{{ old('photo') }}\" name=\"photo\"
                                                style="border: none !important; box-shadow: none !important; background: transparent !important; margin-left: 10px; height: 100% !important; padding-top: 10px;"
                                                placeholder="Select an image...">
                                        </div>

                                        <!--<span class="text-note">*NOTE : Maximum image size must be 1900 x 500</span>                                                                             -->

                                        <div id="holder" style="margin-top:15px;max-height:100px;"></div>

                                    </div>

                                </div>

                                <div class="form-group row">

                                    <label for="status" class="col-sm-2 col-form-label">Url <span
                                            style="color:red">*</span></label>

                                    <div class="col-sm-10">

                                        <input id="url" class="form-control" type="text" name="url" required>

                                    </div>

                                </div>

                                <div class="form-group row">

                                    <label for="status" class="col-sm-2 col-form-label">Status <span
                                            style="color:red">*</span></label>

                                    <div class="col-sm-10">

                                        <select class="form-control" name='status' required>

                                            <option value="">--Status--</option>

                                            <option value="active">Active</option>

                                            <option value="inactive">Inactive</option>

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
@endsection

@section('scripts')
@endsection
