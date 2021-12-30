@extends('layouts.app')

@section('styles')
    <style>
        .jumbotron{
            width: 100%;
            height: 200px;
            background-color: ghostwhite;
            filter: drop-shadow(0px 2px 2px darkgray);
            background-image: linear-gradient(to left, rgba(255,255,255,0.25) 0%,rgba(255,255,255,0.25) 100%), url("{{ asset('images/undraw_Dashboard_re_3b76.png') }}");
            background-position: 77% 100%;
            background-repeat: no-repeat;
            background-size: contain;
        }
        hr{
            width: 100%;
        }
        .disabled{
            filter: invert(75%);
        }
        .btn-block{
            border-radius: 0;
        }
        .btn-block:hover{
            filter: drop-shadow(0 3px 3px darkgray);
        }
        .logo{
            display: block;
            max-height: 50px;
            max-width: 125px;
            left: 0;
        }
        .course-image{
            width: 100%;
            max-height: 150px;
        }
        a.course-title{
            font-family: Helvetica;
            color: dodgerblue;
        }
        a.course-title:hover,a.course-title:focus{
            text-decoration: none;
            color: deepskyblue;
        }
        .wishlist-button{
            outline: none;
            background: transparent;
            border: none;
            padding-left: 0;
        }
        .wishlist-button:hover{
            text-decoration: underline;
        }
        .bg-custom{
            background-color: floralwhite;
        }
        .card-custom{
            top: -20%;
            left: 15%;
            width: 175px;
            box-shadow: 0 1px 2px 0 darkgrey;
        }
    </style>
@endsection

@section('content')
    <div class="container-fluid pl-0 pr-0">
        <div class="jumbotron">
            <div class="container">
                <h1><strong>Courses</strong></h1>
            </div>
        </div>
        <div class="container">
            @forelse($courses as $course)
            <div class="card d-flex flex-column">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-3">
                            <img src="{{ ($course->image_path) ?  $course->image_path : asset('images/No_Image_Available.jpg') }}" class="rounded float-left mb-4 course-image" alt="">
                            @if($course->institution()->exists())
                                <div class="card card-custom bg-custom">
                                    <div class="card-body">
                                        <div class="d-flex justify-content-center">
                                            <img src="{{ $course->institution->logo_path }}" class="logo" alt="{{ $course->institution->name }}">
                                        </div>
                                    </div>
                                </div>
                            @endif
                        </div>
                        <div class="col-md-7">
                            @guest
                            <a href="{{ route('guest.course.show', $course) }}" class="course-title">
                                <h3>{{ $course->title }}</h3>
                            </a>
                            @else
                            <a href="{{ route('course.show', $course) }}" class="course-title">
                                <h3>{{ $course->title }}</h3>
                            </a>
                            @endguest
                            <hr>
                            <div class="d-flex justify-content-between">
                                <p title="rating"><span data-feather="star" class="pr-2" title="rating"></span>{{ number_format($course->ratings()->avg('rating'), 2, '.', ',') }}/10 ({{ $course->ratings()->count() }})</p>
                                <p title="enrolled"><span data-feather="users" class="pr-2" title="enrolled"></span> {{ $course->students()->count() }}</p>
                                <p title="completed"><span data-feather="check-circle" class="pr-2" title="completed"></span> {{ $course->students()->where('has_completed', true)->count() }}</p>
                            </div>
                            <h5><strong>{{ $course->category->name }}</strong></h5>
                            <h6>{{ $course->topic }}</h6>
                            @if($course->instructors()->exists())
                                <br>
                                <h6 class="mt-3">Offered by
                                    <strong> @foreach($course->instructors as $instructor){{ $instructor->name }}@continue($loop->last), @endforeach</strong>
                                </h6>
                            @endif
                        </div>
                        <div class="col-md-2">
                            <p><span data-feather="book" class="pr-1" title="level"></span> {{ $course->level }}</p>
                            <p><span data-feather="clock" class="pr-1" title="duration"></span> {{ $course->duration }}</p>
                            @if ($course->date_starting)
                            <p><span data-feather="calendar" class="pr-1" title="starts from"></span> {{ $course->date_starting }}</p>
                            @endif
                            <p><span data-feather="tag" class="pr-1 @if(!($course->fee)) disabled @endif" title="fee"></span> {{ ($course->fee) ? $course->fee." ".$course->currency : "Free"}}</p>
                            <p><span data-feather="award" class="pr-1 @if(!($course->has_certificate)) disabled @endif" title="certificate"></span> {{ ($course->has_certificate) ? "Offers Certificate" : "No Certificate"}}</p>
                            @guest
                                <form action="{{ route('course.enroll', $course) }}" method="post">
                                    @csrf
                                    <button type="submit" class="btn btn-block btn-primary btn-enroll btn-lg mt-1 mb-1"><strong>ENROLL</strong></button>
                                </form>
                            @else
                                @can('enroll', $course)
                                    <form action="{{ route('course.enroll', $course) }}" method="post">
                                        @csrf
                                        <button type="submit" class="btn btn-block btn-primary btn-enroll btn-lg mt-1 mb-1"><strong>ENROLL</strong></button>
                                    </form>
                                @elsecan('access', $course)
                                    <a href="{{ route('module.index', $course) }}" class="btn btn-block btn-primary btn-enroll btn-lg mt-1 mb-1"><strong>RESUME</strong></a>
                                @else
                                    <button type="button" class="btn btn-block btn-primary btn-enroll btn-lg mt-1 mb-1" disabled><strong>ENROLL</strong></button>
                                @endif
                            @endguest

                            @can('wishlist', $course)
                                <form action="{{ route('wishlist', $course) }}" method="post">
                                    @csrf
                                    <button type="submit" class="text-danger wishlist-button"><span data-feather="bookmark" class="pr-2"></span>wishlist for later</button>
                                </form>
                            @elsecan('removeWishlist', $course)
                                <form action="{{ route('wishlist.remove', $course->wishlists()->where('user_id', auth()->user()->id)->first()) }}" method="post">
                                    @method('DELETE')
                                    @csrf
                                    <button type="submit" class="text-danger wishlist-button">remove from wishlist</button>
                                </form>
                            @endcan
                        </div>
                    </div>
                </div>
            </div>
            <br>
            @empty
                <h4 class="text-center p-5"><strong>NO RECORDS FOUND</strong></h4>
            @endforelse
            <div class="d-flex justify-content-center">
                {{ $courses->links() }}
            </div>
        </div>
    </div>
@endsection
