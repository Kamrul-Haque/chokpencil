@extends('layouts.app')

@section('styles')
    <style>
      .input-group-prepend{
          width: 600px;
      }
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
            <div class="card-header">Create Course</div>

            <div class="card-body">
                <form method="POST" action="{{ route('course.store') }}" enctype="multipart/form-data">
                    @csrf

                    <div class="pl-4 pr-4 pt-1">
                        <div class="form-group">
                            <label for="title">Title<span class="text-danger"> *</span></label>

                            <input id="title" type="text" class="form-control @error('title') is-invalid @enderror" name="title" value="{{ old('title') }}" required autofocus>

                            @error('title')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="subtitle">Subtitle<span class="text-danger"> *</span></label>

                            <textarea id="subtitle" type="text" class="form-control @error('subtitle') is-invalid @enderror" name="subtitle" rows="2" placeholder="1 to 3 sentences" required>{{ old('subtitle') }}</textarea>

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
                                <option value="High School" @if( old('level') === "High School") selected @endif>High School</option>
                                <option value="Secondary" @if( old('level') === "Secondary") selected @endif>Secondary</option>
                                <option value="Higher Secondary" @if( old('level') === "Higher Secondary") selected @endif>Higher Secondary</option>
                                <option value="Diploma" @if( old('level') === "Diploma") selected @endif>Diploma</option>
                                <option value="Undergraduate" @if( old('level') === "Undergraduate") selected @endif>Undergraduate</option>
                                <option value="Graduate" @if( old('level') === "Graduate") selected @endif>Graduate</option>
                                <option value="Post-Graduate" @if( old('level') === "Post-Graduate") selected @endif>Post-Graduate</option>
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
                                <option value="" selected>Please Select...</option>
                                <option value="Beginner" @if( old('difficulty') === "Beginner") selected @endif>Beginner</option>
                                <option value="Intermediate" @if( old('difficulty') === "Intermediate") selected @endif>Intermediate</option>
                                <option value="Advanced" @if( old('difficulty') === "Advanced") selected @endif>Advanced</option>
                                <option value="Professional" @if( old('difficulty') === "Professional") selected @endif>Professional</option>
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
                                <input type="text" class="form-control col-md-8 @error('duration') is-invalid @enderror" name="duration" value="{{ old('duration') }}" required>

                                <select type="text" class="form-control col-md-4 @error('duration_unit') is-invalid @enderror" name="duration_unit">
                                    <option value="" selected>Select Unit</option>
                                    <option value="Days" @if( old('duration_unit') === "Days") selected @endif>Days</option>
                                    <option value="Weeks" @if( old('duration_unit') === "Weeks") selected @endif>Weeks</option>
                                    <option value="Months" @if( old('duration_unit') === "Months") selected @endif>Months</option>
                                    <option value="Years" @if( old('duration_unit') === "Years") selected @endif>Years</option>
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
                                <option value="" selected>Please Select...</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}" @if( old('category') === $category->id) selected @endif>{{ $category->name }}</option>
                                @endforeach
                            </select>

                            @error('category')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="topic">Topic<span class="text-danger"> *</span></label>

                            <input id="topic" type="text" class="form-control @error('topic') is-invalid @enderror" name="topic" value="{{ old('topic') }}" required>

                            @error('topic')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="date_starting">Starting From<span class="text-danger"> *</span></label>

                            <input id="date_starting" type="date" class="form-control @error('date_starting') is-invalid @enderror" name="date_starting" value="{{ old('date_starting') }}" required>

                            @error('date_starting')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="description">Description<span class="text-danger"> *</span></label>

                            <textarea id="description" class="form-control editor @error('description') is-invalid @enderror" name="description" required>{{ old('description') }}</textarea>

                            @error('description')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="completion_marks">Required Marks to Complete the Course</label>

                            <input id="completion_marks" type="text" class="form-control @error('completion_marks') is-invalid @enderror" name="completion_marks" placeholder="percentage(%)" value="{{ old('completion_marks') }}">

                            @error('completion_marks')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="fee">Course Fee</label>

                            <div class="input-group">
                                <input type="text" class="form-control col-md-8 @error('fee') is-invalid @enderror" name="fee" id="fee" value="{{ old('fee') }}">

                                <select type="text" class="form-control col-md-4 @error('currency') is-invalid @enderror" name="currency" id="currency">
                                    <option value="" selected>Select Currency</option>
                                    <option value="GBP" @if( old('currency') === "GBP") selected @endif>GBP</option>
                                    <option value="BDT" @if( old('currency') === "BDT") selected @endif>BDT</option>
                                    <option value="USD" @if( old('currency') === "USD") selected @endif>USD</option>
                                </select>
                                @error('fee')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="image_file">Course image</label>

                            <div id="image_file" class="custom-file">
                                <input id="image" name="image" type="file" class="custom-file-input @error('image') is-invalid @enderror">
                                <label for="image" class="custom-file-label">Image Name</label>

                                @error('image')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                        <br>

                        <div class="form-group">
                            <button type="submit" class="btn custom btn-primary ml-1">
                                Create
                            </button>
                            <a href="{{ url()->previous() }}" class="btn custom btn-light">Cancel</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script type="text/javascript">
        $(".custom-file-input").on("change", function() {
            var fileName = $(this).val().split("\\").pop();
            $(this).siblings(".custom-file-label").addClass("selected").html(fileName);
        });
    </script>
@endsection
