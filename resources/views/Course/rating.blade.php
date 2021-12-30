@extends('layouts.app')

@section('content')
    <div class="container py-4">
        <div class="card">
            <div class="card-header">
                Rating/Review Course
            </div>
            <div class="card-body">
                <form action="{{ route('course.rating.store',$course) }}" method="post">
                    @csrf
                    <h4>Rating</h4>
                    @for($i=1;$i<11;$i++)
                        <div class="custom-control custom-radio custom-control-inline">
                            <input type="radio" name="rating" id="rating{{ $i }}" class="custom-control-input" value="{{ $i }}" required>
                            <label for="rating{{ $i }}" class="custom-control-label">{{ $i }}</label>
                        </div>
                    @endfor
                    <br><br>
                    <div class="form-group">
                        <label for="review">Review</label>
                        <textarea id="review" name="review" class="form-control @error('review') is-invalid @enderror">{{ old('review') }}</textarea>

                        @error('review')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                    <br>
                    <div class="form-group">
                        <button type="submit" class="btn custom btn-primary">Rate</button>
                        <a href="{{ route('course.show', $course) }}" class="btn custom btn-light">Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
