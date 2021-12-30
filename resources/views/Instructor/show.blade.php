@extends('layouts.app')

@section('styles')
    <style>
        .bottom{
            padding-top: 50px;
        }
    </style>
@endsection


@section('content')
    <div class="container py-4">
        <div class="d-flex justify-content-center">
            <div class="card w-50 shadow-sm">
                <div class="card-header">Instructor Profile</div>

                <div class="card-body pl-4">
                    <div class="d-flex row">
                        <div class="col-md-4">
                            <img src="{{ asset('images/No_Image_Available.jpg') }}" alt="" width="85px" height="85px" class="rounded">
                        </div>
                        <div class="text-right bottom col-md-8">
                            <h4 class="font-weight-bolder">{{ $instructor->user->name }}</h4>
                        </div>
                    </div>
                    <hr>

                    <div class="form-group row">
                        <label for="email" class="col-md-4 text-right col-form-label">Email:</label>

                        <div class="col-md-8">
                            <label id="email" type="text" class="form-control-plaintext">{{ $instructor->user->email }}</label>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="designation" class="col-md-4 text-right col-form-label">Unique ID:</label>

                        <div class="col-md-8">
                            <label id="designation" type="text" class="form-control-plaintext">{{ $instructor->uuid }}</label>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="job" class="col-md-4 text-right col-form-label">Designation:</label>

                        <div class="col-md-8">
                            <label id="job" type="text" class="form-control-plaintext">{{ $instructor->designation }}</label>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="department" class="col-md-4 text-right col-form-label">Department:</label>

                        <div class="col-md-8">
                            <label id="department" type="text" class="form-control-plaintext">{{ $instructor->department }}</label>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="institution" class="col-md-4 text-right col-form-label">Institution:</label>

                        <div class="col-md-8">
                            <label id="institution" type="text" class="form-control-plaintext">{{ $instructor->institution }}</label>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="phone" class="col-md-4 text-right col-form-label">Phone:</label>

                        <div class="col-md-8">
                            <label id="phone" type="text" class="form-control-plaintext">{{ $instructor->phone }}</label>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="address" class="col-md-4 text-right col-form-label">Address:</label>

                        <div class="col-md-8">
                            <label id="address" type="text" class="form-control-plaintext">{{ ($instructor->address) ? ($instructor->address) : "no address given" }}</label>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="about" class="col-md-4 text-right col-form-label">About:</label>

                        <div class="col-md-8">
                            <label id="about" type="text" class="form-control-plaintext">{{ $instructor->about }}</label>
                        </div>
                    </div>
                    <hr>

                    <div class="form-group row mb-0 d-flex justify-content-between">
                        <div class="flex-column pl-3">
                            <a href="{{ route('admin.instructor.index') }}" class="btn custom btn-light btn-sm">Back</a>
                        </div>
                        <div class="flex-column pr-3">
                            <div class="d-flex justify-content-end">
                                @if(!$instructor->is_verified)
                                    <form action="{{ route('admin.instructor.verify', $instructor) }}" method="post">
                                        @csrf
                                        <button type="submit" class="btn btn-outline-info btn-sm mr-1">Verify</button>
                                    </form>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
