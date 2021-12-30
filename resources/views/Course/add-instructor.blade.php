@extends('layouts.app')

@section('content')
    <div class="container pt-4">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Add Instructor</div>
                        <div class="card-body">
                        <form method="POST" action="{{ route('course.instructor.store', $course) }}">
                            @method('PUT')
                            @csrf

                            <div class="form-group row">
                                <label for="uuid" class="col-md-4 col-form-label text-md-right">Unique ID of Instructor</label>

                                <div class="col-md-6">
                                    <input id="uuid" type="text" class="form-control @error('uuid') is-invalid @enderror" name="uuid" value="{{ old('uuid') }}" placeholder="can be found in profile" required autofocus>

                                    @error('uuid')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row mb-0">
                                <div class="col-md-6 offset-md-4">
                                    <button type="submit" class="btn custom btn-primary">
                                        Add
                                    </button>
                                    <a href="{{ route('course.show', $course) }}" class="btn custom btn-light">Cancel</a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
