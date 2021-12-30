@extends('layouts.app')

@section('content')
    <div class="container pt-4">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card shadow-sm">
                    <div class="card-header ">
                        Update Profile
                    </div>

                    <div class="card-body">
                        <form method="POST" action="{{ route('user.update', $user) }}">
                            @csrf
                            @method('PUT')

                            <div class="form-group row">
                                <label for="name" class="col-md-4 col-form-label text-md-right">Name</label>

                                <div class="col-md-6">
                                    <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name"  required autocomplete="name" value="{{ old('name') ?? $user->name }}" autofocus>

                                    @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="email" class="col-md-4 col-form-label text-md-right">Email</label>

                                <div class="col-md-6">
                                    <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') ?? $user->email }}" required autocomplete="email">

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
                                        <option value="High School" @if(old('study_level') ?? $user->study_level === "High School") selected @endif>High School</option>
                                        <option value="Secondary" @if(old('study_level') ?? $user->study_level === "Secondary") selected @endif>Secondary</option>
                                        <option value="Higher Secondary" @if(old('study_level') ?? $user->study_level === "Higher Secondary") selected @endif>Higher Secondary</option>
                                        <option value="Diploma" @if(old('study_level') ?? $user->study_level === "Diploma") selected @endif>Diploma</option>
                                        <option value="Undergraduate" @if(old('study_level') ?? $user->study_level === "Undergraduate") selected @endif>Undergraduate</option>
                                        <option value="Graduate" @if(old('study_level') ?? $user->study_level === "Graduate") selected @endif>Graduate</option>
                                        <option value="Post Graduate" @if(old('study_level') ?? $user->study_level === "Post Graduate") selected @endif>Post Graduate</option>
                                    </select>
                                    <small class="form-text text-muted">Tell us what you're studying. We'll find best courses for you.</small>
                                </div>
                            </div>

                            <div class="form-group row mb-0">
                                <div class="col-md-6 offset-md-4">
                                    <a href="{{ url()->previous() }}" class="btn custom btn-light">Cancel</a>
                                    <button type="submit" class="btn custom btn-primary">
                                        Update
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
