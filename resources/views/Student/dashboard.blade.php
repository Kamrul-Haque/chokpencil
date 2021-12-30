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
        <h2 class="h2">Enrolled Courses</h2>
        <br>
        @foreach($courses->chunk(3) as $courseChunks)
        <div class="row">
            @foreach($courseChunks as $course)
            <div class="col-md-4">
                <div class="card">
                    <div class="card-body">
                        <a href="{{ route('course.show', $course) }}" class="course-title">
                            <h2>{{ $course->title }}</h2>
                        </a>
                        <hr>
                        <h3>{{ $course->category->name }}</h3>
                        <h5>{{ $course->topic }}</h5>
                        <h6 class="mt-3">Offered by <strong>@foreach($course->instructors as $instructor){{ $instructor->name }} @endforeach</strong></h6>
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
