@extends('layouts.app')

@section('content')
<div class="container py-4">
    @guest
    <h5 class="text-center">Register as</h5>
    <div class="d-flex justify-content-center pb-4">
        <div class="border border-primary px-5 py-3">
            <a href="#" class="text-decoration-none text-primary">
                <i class="fa fa-user"></i> Student
            </a>
        </div>
        <div class="border px-5 py-3">
            <a href="{{ route('register.instructor.form') }}" class="text-decoration-none text-dark">
                <i class="fas fa-user-graduate"></i> Instructor
            </a>
        </div>
    </div>
    @endguest
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">@guest {{ __('Register') }} @else Create Student @endif</div>

                <div class="card-body">
                    <form method="POST" @guest action="{{ route('register') }}" @else action="{{ route('admin.user.store') }}" @endguest>
                        @csrf

                        <div class="form-group row">
                            <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Name') }}</label>

                            <div class="col-md-6">
                                <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>

                                @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('E-Mail Address') }}</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email">

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="study_level" class="col-md-4 col-form-label text-md-right">Study Level</label>

                            <div class="col-md-6">
                                <select id="study_level" class="form-control @error('study_level') is-invalid @enderror" name="study_level" required>
                                    <option value="" selected>Please Select...</option>
                                    <option value="High School" @if(old('study_level') === "High School") selected @endif>High School</option>
                                    <option value="Secondary" @if(old('study_level') === "Secondary") selected @endif>Secondary</option>
                                    <option value="Higher Secondary" @if(old('study_level') === "Higher Secondary") selected @endif>Higher Secondary</option>
                                    <option value="Diploma" @if(old('study_level') === "Diploma") selected @endif>Diploma</option>
                                    <option value="Undergraduate" @if(old('study_level') === "Undergraduate") selected @endif>Undergraduate</option>
                                    <option value="Graduate" @if(old('study_level') === "Graduate") selected @endif>Graduate</option>
                                    <option value="Post Graduate" @if(old('study_level') === "Post Graduate") selected @endif>Post Graduate</option>
                                </select>
                                <small class="form-text text-muted">Tell us what you're studying. We'll find best courses for you.</small>
                            </div>
                        </div>

                        @guest
                        <div class="form-group row">
                            <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('Password') }}</label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="password-confirm" class="col-md-4 col-form-label text-md-right">{{ __('Confirm Password') }}</label>

                            <div class="col-md-6">
                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
                            </div>
                        </div>
                        @endguest

                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn @guest btn-primary @else btn-dark @endguest custom">
                                    @guest {{ __('Register') }} @else Create @endguest
                                </button>
                                @guest @else <a href="{{ route('admin.user.index') }}" class="btn custom btn-light">Cancel</a> @endguest
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
