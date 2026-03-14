@extends('backend.layouts.master')

@section('content')
    <div class="page-content-wrapper ">

        <div class="container-fluid">

            <div class="row card ">

                <div class="col-sm-12">

                    <div class="float-right page-breadcrumb">

                        <a href="{{ route('tax.index') }}" id="add-btn" style="color: #ffffff;"><i class="fa fa-angle-left"
                        aria-hidden="true"></i> Back</a>

                    </div>

                    <h5 class="page-title">Edit Tax</h5>

                </div>

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

                            <form action="{{ route('tax.update', $tax->id) }}" method="post">

                                @csrf

                                @method('patch')

                                <div class="row">

                                    <div class="col-md-12">

                                        <div class="form-group row">

                                            <label for="example-text-input" class="col-sm-4 col-form-label"> Name : <span
                                                    style="color:red">*</span></label>

                                            <div class="col-sm-8">

                                                <input class="form-control" type="text" placeholder="Enter "
                                                    value="{{ $tax->tax_name }}" required name="tax_name"
                                                    id="example-text-input">

                                            </div>

                                        </div>

                                    </div>

                                    <div class="col-md-12">

                                        <div class="form-group row">

                                            <label for="example-text-input" class="col-sm-4 col-form-label"> Percentage (
                                                Tamil Nadu ) :</label>

                                            <div class="col-sm-8">

                                                <input class="form-control" type="text" placeholder="Enter "
                                                    value="{{ $tax->percentage }}" required name="percentage"
                                                    id="example-text-input">

                                            </div>

                                        </div>

                                    </div>

                                    <?php

                                                    if($tax->id ==1){

                                                    ?>

                                    <div class="col-md-12">

                                        <div class="form-group row">

                                            <label for="example-text-input" class="col-sm-4 col-form-label"> Percentage (
                                                Others ) :</label>

                                            <div class="col-sm-8">

                                                <input class="form-control" type="text" placeholder="Enter "
                                                    value="{{ $tax->percentage1 }}" required name="percentage1"
                                                    id="example-text-input">

                                            </div>

                                        </div>

                                    </div>

                                    <?php } ?>

                                    <div class="col-md-12">

                                        <div class="form-group row">

                                            <label for="status" class="col-sm-4 col-form-label">Status</label>

                                            <div class="col-sm-8">

                                                <select class="form-control" required name='status'>

                                                    <option value="">--Status--</option>

                                                    <option value="active" {{ $tax->status == 'active' ? 'selected' : '' }}>
                                                        Active</option>

                                                    <option value="inactive"
                                                        {{ $tax->status == 'inactive' ? 'selected' : '' }}>Inactive</option>

                                                </select>

                                            </div>

                                        </div>

                                    </div>

                                    <div class=" col-md-12 d-flex">

                                        <button class="btn btn-primary" type="submit">Update</button>&nbsp;

                                        <!-- <button class="btn btn-secondary" type="reset">Cancel</button> -->

                                    </div>

                                </div>

                            </form>

                        </div>

                    </div>

                </div> <!-- end col -->

            </div> <!-- end row -->

        </div><!-- container fluid -->

    </div> <!-- Page content Wrapper -->

    </div> <!-- content -->
@endsection
