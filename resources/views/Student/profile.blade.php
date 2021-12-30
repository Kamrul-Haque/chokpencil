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
            <div class="card-header">Student Profile</div>

            <div class="card-body pl-4">
                <div class="d-flex row">
                    <div class="col-md-4">
                        <img src="{{ auth()->user()->profile_photo_path ?? asset('images/No_Image_Available.jpg') }}" alt="" width="75px" height="75px" class="rounded">
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
                    <label for="study" class="col-md-5 text-right col-form-label">Study Level:</label>

                    <div class="col-md-7">
                        <label id="study" type="text" class="form-control-plaintext">{{ auth()->user()->study_level }}</label>
                    </div>
                </div>

                <hr>
                <div class="form-group row mb-0 justify-content-end">
                    <div class="pr-2 pl-2">
                        <a href="{{ route('user.edit', auth()->user()) }}" class="btn custom btn-primary btn-sm">
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
