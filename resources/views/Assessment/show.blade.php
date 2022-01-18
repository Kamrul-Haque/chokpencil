@extends('layouts.app')

@section('styles')
    <style>
        label{
            font-size: large;
        }
        .form-check-label{
            font-size: medium;
        }
        .feather-content{
            height: 15px;
            width: 15px;
            padding-bottom: 2px;
        }
        .btn-blue{
            background: deepskyblue;
            color: white;
        }
        .btn-blue:hover{
            background: dodgerblue;
            color: white;
        }
    </style>
@endsection

@section('content')
    <div class="container py-4">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <h3 class="col-md-10"><strong>{{ $assessment->title }}</strong></h3>
                    <h5 class="col-md-2 text-right"><strong><span data-feather="calendar" title="deadline"></span> {{$assessment->deadline}}</strong></h5>
                </div>
                <hr>
                <h6>{!! $assessment->description !!}</h6>
                <br>
                @if($assessment->attachment_path)
                    <div class="d-flex justify-content-center border p-3">
                        <span data-feather="file-text"></span>
                        <a href="{{ $assessment->attachment_path }}" class="pl-1">{{ basename($assessment->attachment_path) }}</a>
                    </div>
                @endif
                <br>
                @foreach($assessment->questions as $question)
                    @if(auth()->user()->hasRole('student'))
                        <form action="{{ route('response.store',['course'=>$course,'module'=>$module,'assessment'=>$assessment,'question'=>$question]) }}" method="post" enctype="multipart/form-data">
                            @endif
                            @csrf
                            <div class="form-group">
                                <label for="answer">{{$loop->iteration}}. {{ $question->question }}</label>
                                <span class="float-right text-muted">{{ $question->marks }} marks</span>
                                @if($question->type == 'MCQ')
                                    @if($question->hasMultipleAnswers())
                                        @foreach($question->answers as $answer)
                                            <div class="custom-control custom-checkbox">
                                                <input id="option{{$loop->iteration}}" type="checkbox" name="options[]" class="custom-control-input @error('options') is-invalid @enderror" value="{{ $answer->answer }}">
                                                <label for="option{{$loop->iteration}}" class="custom-control-label">{{ $answer->answer }}</label>

                                                @error('options')
                                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                                @enderror
                                            </div>
                                        @endforeach
                                    @else
                                        @foreach($question->answers as $answer)
                                            <div class="custom-control custom-radio">
                                                <input id="answer{{$loop->iteration}}" type="radio" name="answer" class="custom-control-input @error('answer') is-invalid @enderror" value="{{ $answer->answer }}" required>
                                                <label for="answer{{$loop->iteration}}" class="custom-control-label">{{ $answer->answer }}</label>

                                                @error('answer')
                                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                                @enderror
                                            </div>
                                        @endforeach
                                    @endif
                                @elseif($question->type == 'Descriptive')
                                    <textarea name="answer" rows="5" class="form-control editor @error('answer') is-invalid @enderror" required></textarea>

                                    @error('answer')
                                    <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                                    @enderror
                                @elseif($question->type == 'File Submission')
                                    <div class="custom-file">
                                        <input id="attachment" name="attachment" type="file" class="custom-file-input @error('attachment') is-invalid @enderror" required>
                                        <label for="attachment" class="custom-file-label">File Name</label>

                                        @error('attachment')
                                        <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                                        @enderror
                                    </div>
                                @elseif($question->type == 'Link Submission')
                                    <input type="url" name="link" class="form-control @error('link') is-invalid @enderror" required>

                                    @error('link')
                                    <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                                    @enderror
                                @else
                                    <input id="answer" type="text" name="answer" class="form-control @error('answer') is-invalid @enderror" required>

                                    @error('answer')
                                    <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                                    @enderror
                                @endif
                            </div>
                            @if(auth()->user()->hasRole('student'))
                                @if($question->responses()->where('user_id',auth()->user()->id)->first())
                                    <span class="font-weight-bold">Marks Obtained: {{ $question->responses()->where('user_id',auth()->user()->id)->first()->obtained_marks ?? 'Pending Review' }}</span>
                                @elseif($assessment->getOriginal('deadline') >= today())
                                    <button type="submit" class="btn btn-primary btn-sm">Submit</button>
                                @else
                                    <span class="text-danger font-weight-bolder"><i data-feather="x" class="p-1"></i>Missed</span>
                                @endif
                            @else
                                <div class="d-flex">
                                    @if(!($assessment->is_published))
                                        <a href="{{ route('question.edit',['course'=>$course,'module'=>$module,'assessment'=>$assessment,'question'=>$question]) }}" class="btn btn-sm btn-primary"><span data-feather="edit" class="feather-content"></span></a>
                                        <form action="{{ route('question.destroy',['course'=>$course,'module'=>$module,'assessment'=>$assessment,'question'=>$question]) }}" method="post">
                                            @method('DELETE')
                                            @csrf
                                            <button type="submit" class="btn btn-sm btn-danger ml-1"><span data-feather="trash-2" class="feather-content"></span></button>
                                        </form>
                                    @else
                                        <a href="{{ route('response.index',['course'=>$course,'module'=>$module,'assessment'=>$assessment,'question'=>$question]) }}" class="btn btn-sm btn-success ml-1"><span data-feather="eye" class="feather-content"></span> Responses</a>
                                    @endif
                                </div>
                            @endif
                            @if(auth()->user()->hasRole('student'))
                        </form>
                    @endif
                    <br>
                @endforeach
                @if(!auth()->user()->hasRole('student'))
                    @if(!($assessment->is_published))
                        <br>
                        <a href="{{ route('question.create',['course'=>$course,'module'=>$module,'assessment'=>$assessment]) }}" class="btn custom btn-primary">Create Question</a>
                    @endif
                @endif
                <hr>
                <div class="d-flex">
                    <a href="{{ route('module.index', $module->course) }}" class="btn custom btn-light">Back</a>
                    @if(!($assessment->is_published) && !(auth()->user()->hasRole('student')))
                        <form action="{{ route('assessment.publish', ['course'=>$course,'module'=>$module,'assessment'=>$assessment]) }}" method="post">
                            @csrf
                            <button class="btn custom btn-primary ml-1">Publish</button>
                        </form>
                    @endif
                </div>
            </div>
        </div>
    </div>
    <section>
        <div class="container py-4">
            <h5 class="mb-3 text-center"><strong>Post on Discussion Panel</strong></h5>
            <form method="post" action="{{ route('thread.store', ['course'=>$course,'discussionPanel'=>$course->discussionPanel]) }}">
                @csrf
                <input type="text" name="select" value="{{ $assessment->id }}" hidden>
                <div class="form-group">
                    <label for="subject">Subject</label>
                    <input type="text" id="subject" name="subject" class="form-control @error('subject') is-invalid @enderror" value="{{ old('subject') ?? '' }}" required>

                    @error('subject')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="message">Message</label>
                    <textarea id="message" type="text" class="mt-2 editor form-control @error('message') is-invalid @enderror" name="message" required>{{ old('message') ?? '' }}</textarea>

                    @error('message')
                    <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                    @enderror
                </div>

                <div class="form-group">
                    <button type="submit" class="btn btn-block btn-blue">
                        <strong>Post</strong>
                    </button>
                </div>
            </form>
        </div>
    </section>
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
