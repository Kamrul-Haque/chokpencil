@extends('layouts.app')

@section('styles')
    <style>
        hr{
            width: 100%;
            padding: 0;
        }
        .col-form-label{
            font-size: large;
        }
        a.sidebar {
            -webkit-transition: .3s all ease;
            -o-transition: .3s all ease;
            transition: .3s all ease;
            font-size: 20px;
        }
        a.child {
            -webkit-transition: .3s all ease;
            -o-transition: .3s all ease;
            transition: .3s all ease;
            font-size: 14px;
        }
        a:hover, a:focus {
            text-decoration: none !important;
            outline: none !important;
            -webkit-box-shadow: none;
            box-shadow: none;
        }

        #sidebar {
            position: fixed;
            padding-top: 35px;
            min-width: 300px;
            max-width: 300px;
            min-height: 100vh;
            max-height: 100vh;
            background: white;
            -webkit-transition: all 1s;
            -o-transition: all 1s;
            transition: all 1s;
            z-index: 50;
        }
        #sidebar ul.components {
            padding: 0;
        }
        #sidebar ul li {
            font-size: 14px;
        }
        #sidebar ul li > ul {
            margin-left: 10px;
        }
        #sidebar ul li > ul li {
            font-size: 12px;
        }
        #sidebar ul li a {
            padding: 15px 0;
            display: block;
            color: dodgerblue;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }
        #sidebar ul li a:hover {
            color: black;
        }
        #sidebar ul li.active > a {
            background: transparent;
        }

        a[data-toggle="collapse"] {
            position: relative;
        }

        .dropdown-toggle::after {
            display: block;
            position: absolute;
            top: 50%;
            right: 0;
            -webkit-transform: translateY(-50%);
            -ms-transform: translateY(-50%);
            transform: translateY(-50%);
        }
    </style>
@endsection

@section('content')
    <div class="container py-4">
        @forelse($responses as $response)
            <div class="card">
                <div class="card-title border-bottom py-3">
                    <div class="row">
                        <div class="col-1 text-right">
                            <img src="{{ $response->student->profile_photo ?? asset('images/No_Image_Available.jpg') }}" alt="" width="30px" height="30px" class="rounded-circle">
                        </div>
                        <div class="col-11 text-left">
                            <h4>{{ $response->student->name }}</h4>
                        </div>
                    </div>
                </div>
                <div class="card-body pl-0 pr-0">
                    <div class="pl-4 pr-4">
                        <h4>{{ $question->question }}</h4>
                        <h5>Answers:</h5>
                        @if($response->responseAnswers->first()->attachment_path)
                            <div class="d-flex justify-content-center border p-3">
                                <span data-feather="file-text"></span>
                                <a href="{{ $assessment->attachment_path }}" class="pl-1">{{ basename($assessment->attachment_path) }}</a>
                            </div>
                        @elseif($question->type == 'Descriptive')
                            <h5>{!! $response->responseAnswers->first()->answer !!}</h5>
                        @elseif($question->type == 'Link Submission')
                            <a href="{{ $response->responseAnswers->first()->answer }}" class="link">{{ $response->responseAnswers->first()->answer }}</a>
                        @else
                            @foreach($response->responseAnswers as $answer)
                                <li class="ml-3">{{ $answer->answer }}</li>
                            @endforeach
                        @endif
                    </div>
                    <br>
                    @if($question->needs_review)
                    <hr>
                    <form action="{{ route('response.grade',['course'=>$course,'module'=>$module,'assessment'=>$assessment,'question'=>$question,'response'=>$response]) }}" method="post">
                        @csrf
                        <div class="form-group row pl-2">
                            <label for="marks" class="col-form-label col-md-1 text-right">Marks</label>
                            <div class="col-md-2 pl-0">
                                <input id="marks" type="text" name="marks" class="form-control" value="{{ $response->obtained_marks ?? '' }}" {{ ($response->obtained_marks) ? 'readonly' : '' }}>
                            </div>
                            <h4 class="pl-0 pt-2">/{{ $question->marks }}</h4>
                            <div class="col-md-2 pl-2">
                                <button type="submit" class="btn btn-primary">Grade</button>
                            </div>
                        </div>
                    </form>
                    @endif
                </div>
            </div>
            <br>
        @empty
            <div class="display-4 text-center">No Responses Yet</div>
        @endforelse
        <div class="d-flex justify-content-between">
            <div class="flex-column">
                <a href="{{ route('assessment.show', ['course'=>$course,'module'=>$module,'assessment'=>$assessment]) }}" class="btn custom btn-light">Back</a>
            </div>
            <div class="flex-column justify-content-center">
                <span>{{ $responses->links() }}</span>
            </div>
            <div class="flex-column">

            </div>
        </div>
    </div>
@endsection
