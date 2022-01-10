@extends('layouts.app')

@section('styles')
    <style>
        iframe{
            width: 100vw;
            height: 56.25vh;
            border: 0;
        }
        .link{
            font-size: large;
        }
        .btn-blue{
            background: deepskyblue;
            color: white;
        }
        .btn-blue:hover{
            background: dodgerblue;
            color: white;
        }
        .notepad {
            position: fixed;
            top: 21vh;
            right: 0;
            width: 13vw;
            min-height: 100%;
            max-height: 100%;
            background: rgb(255, 255, 155);
            -webkit-transition: all 1s;
            -o-transition: all 1s;
            transition: all 1s;
            border-left: 1px solid lightgrey;
            z-index: 3;
            overflow-y: hidden;
            overflow-x: hidden;
        }
        .save{
            position: fixed;
            right: 0;
            bottom: 0;
            z-index: 5;
        }
    </style>
@endsection

@section('content')
    {{-- <section>
        @if (!auth()->user()->hasRole('ADMIN'))
            @include('layouts.content-nav')
        @endif
    </section> --}}
    <div class="container">
        <section>
            <div class="container py-4">
                <div class="card">
                    <div class="card-body">
                        <h3><strong>{{ $content->title }}</strong></h3>
                        <hr>
                        <h5>{!! $content->description !!}</h5>
                        <br>
                        <div class="d-flex justify-content-center">
                            @if($content->type == 'Video')
                                <iframe src="http://www.youtube.com/embed/{{ $content->video_link }}" allowfullscreen></iframe>
                            @elseif($content->type == 'File')
                                <div class="row">
                                    <span data-feather="file-text"></span>
                                    <a href="{{ $content->file_path }}" class="pl-1">{{ basename($content->file_path) }}</a>
                                </div>
                            @elseif($content->type == 'Link')
                                <a href="{{ $content->web_link }}" class="link">{{ $content->web_link }}</a>
                            @endif
                        </div>
                        <br>
                        <hr>
                        <a href="{{ route('module.index', $module->course) }}" class="btn custom btn-light">Back</a>
                    </div>
                </div>
                <form action="{{ route('note.save', $content) }}" method="POST">
                    @csrf
                    <textarea name="text" class="notepad">{{ auth()->user()->notes()->where('content_id', $content->id)->first()->text ?? '' }}</textarea>
                    <button type="submit" class="btn btn-sm btn-warning save">Save</button>
                </form>
            </div>
        </section>
        <section>
            <div class="container pt-4">
                <h5 class="mb-3 text-center"><strong>Post on Discussion Panel</strong></h5>
                <form method="post" action="{{ route('thread.store', ['course'=>$course,'discussionPanel'=>$course->discussionPanel]) }}">
                    @csrf
                    <input type="text" name="select" value="{{ $content->id }}" hidden>
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
    </div>
@endsection
