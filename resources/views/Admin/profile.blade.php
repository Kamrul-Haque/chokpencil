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
        <div class="card">
            <div class="card-header">Admin Profile</div>

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
                    <label for="email" class="col-md-5 text-right col-form-label">Email:</label>

                    <div class="col-md-7">
                        <label id="email" type="text" class="form-control-plaintext">{{ auth()->user()->email }}</label>
                    </div>
                </div>

                <div class="form-group row">
                    <label for="designation" class="col-md-5 text-right col-form-label">Employee ID:</label>

                    <div class="col-md-7">
                        <label id="designation" type="text" class="form-control-plaintext">{{ auth()->user()->admin->employee_id }}</label>
                    </div>
                </div>

                <div class="form-group row">
                    <label for="job" class="col-md-5 text-right col-form-label">Job Title:</label>

                    <div class="col-md-7">
                        <label id="job" type="text" class="form-control-plaintext">{{ auth()->user()->admin->job_title }}</label>
                    </div>
                </div>

                <div class="form-group row">
                    <label for="phone" class="col-md-5 text-right col-form-label">Phone:</label>

                    <div class="col-md-7">
                        <label id="phone" type="text" class="form-control-plaintext">{{ auth()->user()->admin->phone }}</label>
                    </div>
                </div>

                <div class="form-group row">
                    <label for="dob" class="col-md-5 text-right col-form-label">Date of Birth:</label>

                    <div class="col-md-7">
                        <label id="dob" type="text" class="form-control-plaintext">{{ auth()->user()->admin->dob }}</label>
                    </div>
                </div>

                <div class="form-group row">
                    <label for="nid" class="col-md-5 text-right col-form-label">NID Number:</label>

                    <div class="col-md-7">
                        <label id="nid" type="text" class="form-control-plaintext">{{ auth()->user()->admin->nid }}</label>
                    </div>
                </div>

                <div class="form-group row">
                    <label for="address" class="col-md-5 text-right col-form-label">Address:</label>

                    <div class="col-md-7">
                        <label id="address" type="text" class="form-control-plaintext">{{ auth()->user()->admin->address ?? "no address given" }}</label>
                    </div>
                </div>
                <hr>

                <div class="form-group row mb-0 justify-content-end">
                    <div class="pr-2 pl-2">
                        <a href="{{ route('profile.edit', auth()->user()) }}" class="btn custom btn-dark btn-sm">
                            Edit Profile
                        </a>
                        <a href="{{ route('photo.upload.form', auth()->user()) }}" class="btn custom btn-dark btn-sm">
                            Upload Profile Photo
                        </a>
                        <a href="{{ route('password.change', auth()->user()) }}" class="btn custom btn-dark btn-sm">
                            Change Password
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
