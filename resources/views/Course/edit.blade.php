@extends('layouts.app')

@section('styles')
    <style>
        .custom-container{
            width: 60vw;
        }
        label{
            font-size: large;
        }
    </style>
@endsection

@section('content')
    <div class="container custom-container p-4">
        <div class="card">
            <div class="card-header">
               Edit Course
            </div>

            <div class="card-body">
                <form method="POST" action="{{ route('course.update', $course) }}" enctype="multipart/form-data">
                    @method('PUT')
                    @csrf

                    <div class="pl-4 pr-4 pt-1">
                        <div class="form-group">
                            <label for="title">Title<span class="text-danger"> *</span></label>

                            <input id="title" type="text" class="form-control @error('title') is-invalid @enderror" name="title" value="{{ old('title') ?? $course->title }}" required autofocus>

                            @error('title')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="subtitle">Subtitle<span class="text-danger"> *</span></label>

                            <textarea id="subtitle" type="text" class="form-control @error('subtitle') is-invalid @enderror" name="subtitle" rows="2" placeholder="1 to 3 sentences" required>{{ old('subtitle') ?? $course->subtitle }}</textarea>

                            @error('subtitle')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="level">Level<span class="text-danger"> *</span></label>

                            <select id="level" name="level" type="text" class="form-control @error('level') is-invalid @enderror" required>
                                <option value="" selected disabled>Please Select...</option>
                                <option value="High School" @if( $course->level == "High School") selected @endif>High School</option>
                                <option value="Secondary" @if( $course->level == "Secondary") selected @endif>Secondary</option>
                                <option value="Higher Secondary" @if( $course->level == "Higher Secondary") selected @endif>Higher Secondary</option>
                                <option value="Diploma" @if( $course->level == "Diploma") selected @endif>Diploma</option>
                                <option value="Undergraduate" @if( $course->level == "Undergraduate") selected @endif>Undergraduate</option>
                                <option value="Graduate" @if( $course->level == "Graduate") selected @endif>Graduate</option>
                                <option value="Post-Graduate" @if( $course->level == "Post-Graduate") selected @endif>Post-Graduate</option>
                            </select>

                            @error('level')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>

                        <div id="group" class="form-group">
                            <label for="difficulty">Difficulty<span class="text-danger"> *</span></label>

                            <select id="difficulty" name="difficulty" type="text" class="form-control @error('difficulty') is-invalid @enderror" required>
                                <option value="" selected disabled>Please Select...</option>
                                <option value="Beginner" @if( old('difficulty') ?? $course->difficulty === "Beginner") selected @endif>Beginner</option>
                                <option value="Intermediate" @if( old('difficulty') ?? $course->difficulty === "Intermediate") selected @endif>Intermediate</option>
                                <option value="Advanced" @if( old('difficulty') ?? $course->difficulty === "Advanced") selected @endif>Advanced</option>
                                <option value="Expert" @if( old('difficulty') ?? $course->difficulty === "Expert") selected @endif>Expert</option>
                            </select>

                            @error('difficulty')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="duration">Duration<span class="text-danger"> *</span></label>

                            <div id="duration" class="input-group">
                                <input type="text" class="form-control col-md-8 @error('duration') is-invalid @enderror" name="duration" value="{{ old('duration') ?? $duration[0] }}" required>

                                <select type="text" class="form-control col-md-4 @error('duration_unit') is-invalid @enderror" name="duration_unit">
                                    <option value="" selected disabled>Select Unit</option>
                                    <option value="Days" @if( old('duration_unit') ?? $duration[1] === "Days") selected @endif>Days</option>
                                    <option value="Weeks" @if( old('duration_unit') ?? $duration[1] === "Weeks") selected @endif>Weeks</option>
                                    <option value="Months" @if( old('duration_unit') ?? $duration[1] === "Months") selected @endif>Months</option>
                                    <option value="Years" @if( old('duration_unit') ?? $duration[1] === "Years") selected @endif>Years</option>
                                </select>

                                @error('duration')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <div id="group" class="form-group">
                            <label for="category">Category<span class="text-danger"> *</span></label>

                            <select id="category" name="category" type="text" class="form-control @error('category') is-invalid @enderror" required>
                                <option value="" selected disabled>Please Select...</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}" @if( old('category') ?? $course->category->id === $category->id) selected @endif>{{ $category->name }}</option>
                                @endforeach
                            </select>

                            @error('$category')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="topic">Topic<span class="text-danger"> *</span></label>

                            <input id="topic" type="text" class="form-control @error('topic') is-invalid @enderror" name="topic" value="{{ old('topic') ?? $course->topic }}" required>

                            @error('topic')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="date_starting">Starting From<span class="text-danger"> *</span></label>

                            <input id="date_starting" type="date" class="form-control @error('date_starting') is-invalid @enderror" name="date_starting" value="{{ old('date_starting') ?? $course->date_starting }}" required>

                            @error('date_starting')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="description">Description<span class="text-danger"> *</span></label>

                            <textarea id="description" class="form-control editor @error('description') is-invalid @enderror" name="description" required>{{ old('description') ?? $course->description }}</textarea>

                            @error('description')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="completion_marks">Required Marks to Complete the Course</label>

                            <input id="completion_marks" type="text" class="form-control @error('completion_marks') is-invalid @enderror" name="completion_marks" placeholder="percentage(%)" value="{{ old('completion_marks') ?? $course->completion_marks }}">

                            @error('completion_marks')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="fee">Course Fee</label>

                            <div class="input-group">
                                <input type="text" class="form-control col-md-8 @error('fee') is-invalid @enderror" name="fee" id="fee" value="{{ old('fee') ?? $course->fee }}">

                                <select type="text" class="form-control col-md-4 @error('currency') is-invalid @enderror" name="currency" id="currency">
                                    <option value="" selected disabled>Select Currency</option>
                                    <option value="GBP" @if( old('currency') ?? $course->currency === "GBP") selected @endif>GBP</option>
                                    <option value="BDT" @if( old('currency') ?? $course->currency === "BDT") selected @endif>BDT</option>
                                    <option value="USD" @if( old('currency') ?? $course->currency === "USD") selected @endif>USD</option>
                                </select>
                                @error('fee')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                        <br>

                        <div class="form-group">
                            <button type="submit" class="btn custom btn-primary">
                                Update
                            </button>
                            <a href="{{ url()->previous() }}" class="btn custom btn-light">Cancel</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
