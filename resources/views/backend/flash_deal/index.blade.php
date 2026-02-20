@extends('backend.layouts.master')

@section('content')
<div class="page-content-wrapper ">
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12">
                <div class="float-right page-breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="#">Appearance</a></li>
                        <li class="breadcrumb-item active">Flash Deals</li>
                    </ol>
                </div>
                <h5 class="page-title">Flash Deals</h5>
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <div class="card m-b-30">
                    <div class="card-body">
                        <h4 class="mt-0 header-title">Flash Deals List</h4>
                        <a href="{{ route('flash-deals.create') }}" class="btn btn-primary waves-effect waves-light mb-3">Create New Deal</a>
                        
                        <div class="table-responsive">
                            <table class="table table-hover mb-0">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Title</th>
                                        <th>Deal End Date</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($deals as $deal)
                                    <tr>
                                        <th scope="row">{{ $deal->id }}</th>
                                        <td>{{ $deal->title }}</td>
                                        <td>{{ $deal->deal_end_date }}</td>
                                        <td>
                                            @if($deal->status == 'active')
                                            <span class="badge badge-success">Active</span>
                                            @else
                                            <span class="badge badge-danger">Inactive</span>
                                            @endif
                                        </td>
                                        <td>
                                            <a href="{{ route('flash-deals.edit', $deal->id) }}" class="btn btn-primary btn-sm"><i class="fa fa-edit"></i></a>
                                            <form action="{{ route('flash-deals.destroy', $deal->id) }}" method="POST" style="display:inline-block;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure?')"><i class="fa fa-trash"></i></button>
                                            </form>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
