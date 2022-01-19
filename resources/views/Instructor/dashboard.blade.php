@extends('layouts.app')

@section('styles')
    <style>
        .logo{
            display: block;
            max-height: 50px;
            left: 0;
        }
    </style>
@endsection

@section('content')
    <div class="container py-4">
        <h2 class="h2">Your Courses</h2>
        <br>
        @foreach($courses->chunk(3) as $courseChunks)
        <div class="row">
            @foreach($courseChunks as $course)
            <div class="col-md-4">
                <div class="card">
                    <div class="card-body">
                        <a href="{{ route('course.show', $course) }}" class="course-title">
                            <h3>{{ $course->title }}</h3>
                        </a>
                        <hr>
                        <h5>{{ $course->category->name }}</h5>
                        <h6>{{ $course->topic }}</h6>
                        <div class="d-flex justify-content-between">
                            <p title="rating"><span data-feather="star" class="pr-2" title="rating"></span>{{ number_format($course->ratings()->avg('rating'), 2, '.', ',') }}/10 ({{ $course->ratings()->count() }})</p>
                            <p title="enrolled"><span data-feather="users" class="pr-2" title="enrolled"></span> {{ $course->students()->count() }}</p>
                            <p title="completed"><span data-feather="check-circle" class="pr-2" title="completed"></span> {{ $course->students()->where('has_completed', true)->count() }}</p>
                        </div>
                        <hr>
                        <div>
                            @if($course->institution)
                                <div class="d-flex justify-content-center">
                                    <img src="{{ $course->institution->logo_path }}" class="logo" alt="">
                                </div>
                            @endif
                        </div>
                        <br>
                        <div>
                            <a href="{{ route('module.index', $course) }}" class="btn btn-block btn-primary">Resume</a>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        @endforeach
    </div>
@endsection
