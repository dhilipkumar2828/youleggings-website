@extends('backend.layouts.master')

@section('content')
    <div class="page-content-wrapper ">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-12">
                    <div class="float-right page-breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a>Appearance</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('testimonial.index') }}">Testimonials</a></li>
                            <li class="breadcrumb-item active">Add Testimonial</li>
                        </ol>
                    </div>
                    <h5 class="page-title">Add Testimonial</h5>
                </div>
            </div>

            <div class="row">
                <div class="col-12">
                    <div class="card m-b-30">
                        <div class="card-body">
                            <form action="{{ route('testimonial.store') }}" method="POST">
                                @csrf
                                <div class="form-group row">
                                    <label for="name" class="col-sm-2 col-form-label">Customer Name</label>
                                    <div class="col-sm-10">
                                        <input class="form-control" type="text" name="name" id="name" required placeholder="Enter customer name">
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="phone_number" class="col-sm-2 col-form-label">Phone Number</label>
                                    <div class="col-sm-10">
                                        <input class="form-control" type="text" name="phone_number" id="phone_number" placeholder="Enter phone number (optional)">
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="feedback" class="col-sm-2 col-form-label">Feedback / Testimonial</label>
                                    <div class="col-sm-10">
                                        <textarea class="form-control" name="feedback" id="feedback" rows="5" required placeholder="Enter testimonial content"></textarea>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="status" class="col-sm-2 col-form-label">Status</label>
                                    <div class="col-sm-10">
                                        <input type="checkbox" name="status" id="status" 
                                            data-toggle="switchbutton" checked
                                            data-onlabel="Active" data-offlabel="Inactive"
                                            data-onstyle="success" data-offstyle="danger" value="active">
                                    </div>
                                </div>

                                <div class="form-group row float-right text-right">
                                    <div class="col-sm-10 offset-sm-2">
                                        <button type="submit" class="btn btn-primary">Save </button>
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
