@extends('layouts.app')

@section('styles')
    <style>
        .bottom{
            padding-top: 50px;
        }
        .custom-continer{
            width: 60vh;
        }
    </style>
@endsection


@section('content')
    <div class="container custom-continer py-4">
        <div class="card shadow-sm">
            <div class="card-header">Instructor Profile</div>

            <div class="card-body pl-4">
                <div class="d-flex row">
                    <div class="col-md-4">
                        <img src="{{ auth()->user()->profile_photo_path ?? asset('images/No_Image_Available.jpg') }}" alt="" width="85px" height="85px" class="rounded">
                    </div>
                    <div class="text-right bottom col-md-8">
                        <h4 class="font-weight-bolder">{{ auth()->user()->name }}</h4>
                    </div>
                </div>
                <hr>

                <div class="form-group row">
                    <label for="email" class="col-md-4 text-right col-form-label">Email:</label>

                    <div class="col-md-8">
                        <label id="email" type="text" class="form-control-plaintext">{{ auth()->user()->email }}</label>
                    </div>
                </div>

                <div class="form-group row">
                    <label for="designation" class="col-md-4 text-right col-form-label">Unique ID:</label>

                    <div class="col-md-8">
                        <label id="designation" type="text" class="form-control-plaintext">{{ auth()->user()->instructor->uuid }}</label>
                    </div>
                </div>

                <div class="form-group row">
                    <label for="job" class="col-md-4 text-right col-form-label">Designation:</label>

                    <div class="col-md-8">
                        <label id="job" type="text" class="form-control-plaintext">{{ auth()->user()->instructor->designation }}</label>
                    </div>
                </div>

                <div class="form-group row">
                    <label for="department" class="col-md-4 text-right col-form-label">Department:</label>

                    <div class="col-md-8">
                        <label id="department" type="text" class="form-control-plaintext">{{ auth()->user()->instructor->department }}</label>
                    </div>
                </div>

                <div class="form-group row">
                    <label for="institution" class="col-md-4 text-right col-form-label">Institution:</label>

                    <div class="col-md-8">
                        <label id="institution" type="text" class="form-control-plaintext">{{ auth()->user()->instructor->institution }}</label>
                    </div>
                </div>

                <div class="form-group row">
                    <label for="phone" class="col-md-4 text-right col-form-label">Phone:</label>

                    <div class="col-md-8">
                        <label id="phone" type="text" class="form-control-plaintext">{{ auth()->user()->instructor->phone }}</label>
                    </div>
                </div>

                <div class="form-group row">
                    <label for="address" class="col-md-4 text-right col-form-label">Address:</label>

                    <div class="col-md-8">
                        <label id="address" type="text" class="form-control-plaintext">{{ auth()->user()->instructor->address ?? "no address given" }}</label>
                    </div>
                </div>

                <div class="form-group row">
                    <label for="about" class="col-md-4 text-right col-form-label">About:</label>

                    <div class="col-md-8">
                        <label id="about" type="text" class="form-control-plaintext">{{ auth()->user()->instructor->about }}</label>
                    </div>
                </div>
                <hr>

                <div class="form-group row mb-0 justify-content-end">
                    <div class="pr-2 pl-2">
                        <a href="{{ route('profile.edit', auth()->user()) }}" class="btn custom btn-primary btn-sm">
                            Edit Profile
                        </a>
                        <a href="{{ route('photo.upload.form', auth()->user()) }}" class="btn custom btn-primary btn-sm">
                            Upload Profile Photo
                        </a>
                        <a href="{{ route('password.change', auth()->user()) }}" class="btn custom btn-primary btn-sm">
                            Change Password
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
