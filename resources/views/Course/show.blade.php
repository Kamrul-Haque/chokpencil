@extends('layouts.app')

@section('styles')
    <style>
        .jumbotron{
            position: relative;
            width: 100%;
            background-color: ghostwhite;
            filter: drop-shadow(0px 1px 1px darkgray);
            padding-bottom: 20px;
            background-image: linear-gradient(to left, rgba(255,255,255,0.9) 0%,rgba(255,255,255,0.9) 100%), url("{{ $course->image_path }}");
            background-position: center;
            background-repeat: no-repeat;
            background-size: cover;
            z-index: 2;
        }
        .dropdown-button{
            border: 0;
            background: transparent;
            color: black;
        }
        .dropdown-button:focus{
            outline: none;
            border: 0;
            color: dodgerblue;
        }
        .course-title{
            color: dodgerblue;
            font-weight: 900;
        }
        .btn-enroll{
            border-radius: 0;
            font-size: 30px;
        }
        .logo{
            display: block;
            max-height: 75px;
        }
        .card{
            filter: drop-shadow(0px 1px 1px darkgray);
        }
        .headings{
            font-family: Calibri;
        }
        .contents{
            font-family: "Calibri Light";
        }
        .disabled {
            filter: invert(75%);
        }
        .feather.function{
            height: 20px;
            padding-right: 5px;
            width: auto;
        }
        button::-moz-focus-inner{
            border: 0!important;
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
    </style>
@endsection

@section('content')
    <div class="container-fluid pl-0 pr-0 pb-4">
        <section>
            <div class="jumbotron">
                <div class="container">
                    <div class="row">
                        <div class="col-md-11">
                            <h1 class="course-title">{{ $course->title }}</h1>
                        </div>
                        <div class="col-md-1">
                            @can('access', $course)
                                <div class="dropdown">
                                    <button class="dropdown-button float-right pt-4" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        <span data-feather="settings" class="function"></span>
                                    </button>
                                    <div class="dropdown-menu dropdown-menu-right text-right" aria-labelledby="dropdownMenuButton">
                                        <a href="{{ route('module.index', $course) }}" class="dropdown-item">Course Modules</a>
                                        @can('rate', $course)
                                            @if(!$course->rated())
                                                <a href="{{ route('course.rating', $course) }}" class="dropdown-item">Rate/Review this Course</a>
                                            @else
                                                <a href="{{ route('course.rating.edit',['course'=>$course,'rating'=>$course->ratings()->where('user_id',auth()->user()->id)->first()]) }}" class="dropdown-item">Edit Rating/Review</a>
                                            @endif
                                            <button type="submit" class="dropdown-item text-danger" data-toggle="modal" data-target="#unEnroll"><strong>UN-ENROLL</strong></button>
                                        @endcan
                                        @can('modify', $course)
                                            <a href="{{ route('course.edit', $course) }}" class="dropdown-item" title="edit">Edit</a>
                                            @if(auth()->user()->hasRole('admin'))
                                                <button type="button" class="dropdown-item" data-toggle="modal" data-target="#delete">Delete</button>
                                            @endif
                                            <a href="{{ route('course.add.instructor', $course) }}" class="dropdown-item">Add Instructor</a>
                                            <a href="{{ route('course.image.form', $course) }}" class="dropdown-item">Upload/Change Image</a>
                                            @can('leaveCourse', $course)
                                            <button type="button" class="dropdown-item text-danger" data-toggle="modal" data-target="#leave">Leave Course</button>
                                            @endcan
                                            @can('assignInstitution', $course)
                                                <a href="{{ route('admin.course.assign.institution', $course) }}" class="dropdown-item">Assign Institution</a>
                                            @endcan
                                            @if(auth()->user()->hasRole('admin'))
                                                <a href="{{ route('admin.course.enroll.students.form', $course) }}" class="dropdown-item">Enroll Students</a>
                                            @endif
                                        @endif
                                    </div>
                                </div>
                            @endcan
                        </div>
                    </div>
                    <h4>{{ $course->subtitle ?? '' }}</h4>
                    <p class="font-weight-bolder pt-1"><span data-feather="star" class="pr-2" title="rating"></span><strong>{{ number_format($course->ratings()->avg('rating'), 2, '.', ',') }}/10</strong> on <strong>{{ $course->ratings()->count() }}</strong> ratings</p>
                    <div class="row">
                        <div class="col-md-3 pt-5">
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

                            <p class="font-weight-bolder"><strong>{{ $course->students()->count() }}</strong> students currently enrolled</p>

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
                        @if($course->institution()->exists())
                        <div class="col-md-5 pt-5"></div>
                         <div class="col-md-4 pt-5 text-right">
                            <h5>Certified By</h5>
                            <div class="float-right">
                                <img src="{{ $course->institution->logo_path }}" class="logo" alt="{{ $course->institution->name }}">
                            </div>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </section>
        <section>
            <div class="container">
                <div class="row">
                    <div class="col-md-8">
                        <h2 class="pb-2 headings">COURSE DESCRIPTION</h2>
                        <div>
                            <h5 class="contents">{!! $course->description !!}</h5>
                        </div>
                        <br>
                        @if($course->instructors()->exists())
                        <h2 class="pb-2 headings">INSTRUCTORS</h2>
                        @foreach($course->instructors as $instructor)
                        <div class="row">
                            <div class="col-md-1 text-right">
                                <img src="{{ ($instructor->profile_photo_path) ? $instructor->profile_photo_path : asset('images/No_Image_Available.jpg') }}" alt="" class="rounded-circle" width="25px" height="25px">
                            </div>
                            <div class="col-md-5">
                                <h5><strong>{{ $instructor->name }}</strong></h5>
                                <p>{{ $instructor->instructor->designation }}, {{ $instructor->instructor->institution }}<br>{{ $instructor->instructor->about }}</p>
                            </div>
                        </div>
                        @endforeach
                        <br>
                        @endif
                        @if($course->ratings()->exists())
                        <h2 class="pb-2 headings">Reviews</h2>
                        @foreach($course->ratings as $rating)
                            <div class="row">
                                <div class="col-md-1 text-right">
                                    <img src="{{ ($rating->user->profile_photo_path) ? $rating->user->profile_photo_path : asset('images/No_Image_Available.jpg') }}" alt="" class="rounded-circle" width="25px" height="25px">
                                </div>
                                <div class="col-md-5">
                                    <h5><strong>{{ $rating->user->name }}</strong></h5>
                                    <small class="text-muted">{{ $rating->date }}</small>
                                    <p>{{ $rating->review }}</p>
                                </div>
                            </div>
                        @endforeach
                        @endif
                    </div>
                    <div class="col-md-4">
                        <div class="card">
                            <div class="card-body">
                                <h4><span data-feather="book-open" title="level" style="height: 23px; width: auto"></span> CATEGORY: {{ $course->category->name }}</h4>
                                <h5></h5>
                                <br>
                                <h4><span data-feather="pie-chart" title="level" style="height: 23px; width: auto"></span> TOPIC: {{ $course->topic }}</h4>
                                <h5></h5>
                            </div>
                        </div>
                        <br>
                        <div class="card">
                            <div class="card-body">
                                <h5><span data-feather="book" title="level"></span> LEVEL: {{ $course->level }}</h5>
                                <br>
                                <h5><span data-feather="clock" title="duration"></span> DURATION: {{ $course->duration }}</h5>
                                <br>
                                @if ($course->date_starting)
                                <h5><span data-feather="calendar" title="starts from"></span> STARTS: {{ $course->date_starting }}</h5>
                                <br>
                                @endif
                                <h5><span data-feather="tag" class="@if(!($course->fee)) disabled @endif" title="fee"></span> FEE: {{ ($course->fee) ? $course->fee." ".$course->currency : "Free"}}</h5>
                                <br>
                                <h5><span data-feather="award" class="@if(!($course->has_certificate)) disabled @endif" title="certificate"></span> {{ ($course->has_certificate) ? "Offers Certificate" : "No Certificate"}}</h5>
                            </div>
                        </div>
                        <br><br>
                        <h5 class="text-center">Enquire About Course</h5>
                        <form action="{{ route('enquiry.store') }}" class="pt-2" method="POST">
                            @csrf
                            <input type="text" name="course_id" value="{{$course->id}}" hidden>
                            <label for="name">Name</label>
                            <input type="text" id="name" name="name" class="form-control" value="{{old('name')}}" required>
                            <br>
                            <label for="email">Email</label>
                            <input type="email" id="email" name="email" class="form-control" value="{{old('email')}}" required>
                            <br>
                            <label for="phone">Phone</label>
                            <input type="text" id="phone" name="phone" class="form-control" value="{{old('phone')}}">
                            <br>
                            <label for="enquiry">Enquiry</label>
                            <textarea name="enquiry" id="enquiry" rows="3" class="form-control" required>{{old('enquiry')}}</textarea>
                            <br>
                            <button type="submit" class="btn btn-primary btn-sm custom float-right">Enquire</button>
                        </form>
                    </div>
                </div>
            </div>
        </section>
        @component('components.modal')
            @slot('id') delete @endslot
            @slot('title') Delete Confirmation @endslot
            @slot('type') danger @endslot
            @slot('action') action="{{ route('course.destroy', $course) }}" @endslot
            @slot('method') DELETE @endslot
            Do you really want to delete the Course? All Contents will be deleted as well!
        @endcomponent

        @component('components.modal')
            @slot('id') unEnroll @endslot
            @slot('title') Un-Enrollment Confirmation @endslot
            @slot('type') danger @endslot
            @slot('action') action="{{ route('course.unenroll', $course) }}" @endslot
            Do you really want to Un-Enroll the Course? Your progress will be deleted!
        @endcomponent

        @component('components.modal')
            @slot('id') leave @endslot
            @slot('title') Confirmation @endslot
            @slot('type') danger @endslot
            @slot('action') action="{{ route('course.instructor.leave', $course) }}" @endslot
            Do you really want to leave the Course? Your uploaded contents will still be available!
        @endcomponent
    </div>
@endsection
