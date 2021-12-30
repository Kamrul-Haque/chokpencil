@extends('layouts.app')

@section('styles')
    <style>
        .content-link{
            color: black;
            font-size: large;
        }
        .jumbotron{
            width: 100%;
            height: 200px;
            background-color: ghostwhite;
            filter: drop-shadow(0px 2px 2px darkgray);
            background-image: linear-gradient(to left, rgba(255,255,255,0.25) 0%,rgba(255,255,255,0.25) 100%), url("{{ asset('images/undraw_Community_re_cyrm.png') }}");
            background-position: 77% 100%;
            background-repeat: no-repeat;
            background-size: contain;
        }
    </style>
@endsection

@section('content')
    <div class="container-fluid pl-0 pr-0">
        <div class="jumbotron">
            <div class="container">
                <h1><strong>Discussion Panel</strong></h1>
            </div>
        </div>
        <div class="container py-4">
            <div class="row">
                <div class="col-md-3">
                    <div class="list-group">
                        <h4>Filter</h4>
                        <div class="list-group-item">
                            <a href="{{ route('thread.index', ['course'=>$course, 'discussionPanel'=>$discussionPanel]) }}" class="content-link">All Posts</a>
                        </div>
                        <div class="list-group-item">
                            <a href="{{ route('thread.filter', ['course'=>$course, 'discussionPanel'=>$discussionPanel, 'content'=>'0']) }}" class="content-link">General Discussion</a>
                        </div>
                        @foreach($course->modules as $module)
                            <div class="list-group-item px-0">
                                <h4 class="content-link pl-3"><strong>{{ $module->module_name }}</strong></h4>
                                <hr>
                                @foreach($module->contents as $content)
                                <div class="pl-4">
                                    <a href="{{ route('thread.filter',['course'=>$course, 'discussionPanel'=>$discussionPanel, 'content'=>$content->id]) }}" class="content-link pl-2">{{ $content->title }}</a>
                                </div>
                                <hr>
                                @endforeach
                            </div>
                        @endforeach
                    </div>
                </div>
                <div class="col-md-9">
                    <h4>Posts</h4>
                    <div class="card">
                        <div class="card-body">
                            @forelse($threads as $thread)
                            <div>
                                <a href="{{ route('thread.show', ['course'=>$course, 'discussionPanel'=>$discussionPanel, 'thread'=>$thread]) }}" class="content-link">{{ $thread->subject }}</a>
                                @if($thread->hasSolution()) <span class="text-success ml-1"><i>solved!</i></span> @endif
                                <span class="float-right text-muted"><small>{{ $thread->createdAtTime() }} &#9679; {{ $thread->created_at }}</small></span>
                                <br>
                                <span class="text-muted">posted by @if( $thread->user_id ) {{ $thread->user->name }} @else <em class="text-danger">Admin</em> @endif</span>
                                <p>{!! Str::limit($thread->body,250) !!}</p>
                            </div>
                            <hr>
                            @empty
                                <h4 class="text-center">No Threads Yet.</h4>
                            @endforelse
                        </div>
                    </div>
                    <br>
                    <div class="d-flex justify-content-between">
                        <div class="d-block">
                            <a href="{{ route('module.index', $course) }}" class="btn custom btn-light">Back</a>
                        </div>
                        {{ $threads->links() }}
                        <div class="d-block">
                            <a href="{{ route('thread.create', ['course'=>$course, 'discussionPanel'=>$discussionPanel]) }}" class="float-right btn custom btn-primary mb-1">New Post</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script type='text/javascript'>
        $(function(){
            $('.card-body>hr:last-child').remove();
            $('.list-group-item>hr:last-child').remove();
        });
    </script>
@endsection
