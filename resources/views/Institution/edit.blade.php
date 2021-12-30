@extends('layouts.app')

@section('styles')
    <style>
        .container{
            width: 50%;
        }
        label{
            font-size: large;
        }
    </style>
@endsection

@section('content')
    <div class="container py-4">
        <div class="card">
            <div class="card-header">
                Edit Institution
            </div>

            <div class="card-body">
                <form method="POST" action="{{ route('admin.institution.update',$institution) }}" enctype="multipart/form-data">
                    @method('PUT')
                    @csrf
                    <div class="pl-4 pr-4 pt-1">
                        <div class="form-group">
                            <label for="name">Name</label>
                            <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ $institution->name }}" required autofocus>

                            @error('name')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="email">Email</label>
                            <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ $institution->email }}" required>

                            @error('email')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="phone">Phone</label>
                            <input id="phone" type="tel" class="form-control @error('phone') is-invalid @enderror" name="phone" value="{{ $institution->phone }}" required>

                            @error('phone')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="address">Address</label>
                            <textarea id="address" class="form-control @error('address') is-invalid @enderror" name="address">{{ $institution->address }}</textarea>

                            @error('address')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <legend for="education">Education Level</legend>
                            <div id="education" class="row">
                                <div class="col-md-6">
                                    <label for="lower_level">From</label>
                                    <select name="lower_level" id="lower_level" class="form-control" required>
                                        <option value="" selected disabled>Please Select...</option>
                                        <option value="High School" @if( $institution->study_level_lower == "High School") selected @endif>High School</option>
                                        <option value="Secondary" @if( $institution->study_level_lower == "Secondary") selected @endif>Secondary</option>
                                        <option value="Higher Secondary" @if( $institution->study_level_lower == "Higher Secondary") selected @endif>Higher Secondary</option>
                                        <option value="Diploma" @if( $institution->study_level_lower == "Diploma") selected @endif>Diploma</option>
                                        <option value="Undergraduate" @if( $institution->study_level_lower == "Undergraduate") selected @endif>Undergraduate</option>
                                        <option value="Graduate" @if( $institution->study_level_lower == "Graduate") selected @endif>Graduate</option>
                                        <option value="Post-Graduate" @if( $institution->study_level_lower == "Post-Graduate") selected @endif>Post-Graduate</option>
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <label for="upper_level">To</label>
                                    <select name="upper_level" id="upper_level" class="form-control" required>
                                        <option value="" selected disabled>Please Select...</option>
                                        <option value="High School" @if( $institution->study_level_upper == "High School") selected @endif>High School</option>
                                        <option value="Secondary" @if( $institution->study_level_upper == "Secondary") selected @endif>Secondary</option>
                                        <option value="Higher Secondary" @if( $institution->study_level_upper == "Higher Secondary") selected @endif>Higher Secondary</option>
                                        <option value="Diploma" @if( $institution->study_level_upper == "Diploma") selected @endif>Diploma</option>
                                        <option value="Undergraduate" @if( $institution->study_level_upper == "Undergraduate") selected @endif>Undergraduate</option>
                                        <option value="Graduate" @if( $institution->study_level_upper == "Graduate") selected @endif>Graduate</option>
                                        <option value="Post-Graduate" @if( $institution->study_level_upper == "Post-Graduate") selected @endif>Post-Graduate</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div id="attachment-file" class="form-group">
                            <label for="file-group">Upload Logo</label>

                            <div id="file-group" class="custom-file">
                                <input id="logo" name="logo" type="file" class="custom-file-input @error('logo') is-invalid @enderror">
                                <label for="logo" class="custom-file-label">File Name</label>

                                @error('logo')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group pt-3">
                            <div>
                                <button type="submit" class="btn custom btn-dark">
                                    Update
                                </button>
                                <a href="{{ route('admin.institution.index') }}" class="btn custom btn-light">Cancel</a>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script type="text/javascript">
        $(document).ready(function () {
            $(".custom-file-input").on("change", function () {
                var fileName = $(this).val().split("\\").pop();
                $(this).siblings(".custom-file-label").addClass("selected").html(fileName);
            });
        });
    </script>
@endsection
