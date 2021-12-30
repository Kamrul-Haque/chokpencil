@extends('layouts.app')

@section('styles')
    <style>
        .dropdown-button{
            outline: none;
            background: transparent;
            border: none;
        }
        .dropdown-button:hover{
            text-decoration: underline;
        }
        .reply-card{
            background: azure;
            border-top-left-radius: 0;
            width: 100%;
        }
        .reply-card:focus{
            box-shadow: none;
            background-color: azure;
        }
        .feather-content{
            width: 15px;
            height: auto;
        }
        textarea {
            resize: none;
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
        <div class="card mt-3">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <h4 class="display-4">{{ $thread->subject }}</h4>
                    @can('modify', $thread)
                    <div class="dropdown">
                        <a class="text-secondary" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <span data-feather="more-horizontal"></span>
                        </a>

                        <div class="dropdown-menu dropdown-menu-right bg-dark border-0" aria-labelledby="dropdownMenuButton">
                            <a href="{{ route('thread.edit', ['course'=>$course, 'discussionPanel'=>$discussionPanel, 'thread'=>$thread]) }}" class="dropdown-item dropdown-button text-info text-right">Edit</a>
                            <hr>
                            <form action="{{ route('thread.destroy', ['course'=>$course, 'discussionPanel'=>$discussionPanel, 'thread'=>$thread]) }}" method="post">
                                @method('DELETE')
                                @csrf
                                <button type="submit" class="text-danger ml-1 dropdown-button dropdown-item text-right">Delete</button>
                            </form>
                        </div>
                    </div>
                    @endcan
                </div>
                <h6 class="text-muted pb-2">{{ $thread->content->title ?? "General Discussion" }}</h6>
                <span>
                    @if( $thread->user_id ) <img src="{{ $thread->user->profile_photo_path ?? asset('images/No_Image_Available.jpg') }}" alt="profile photo" class="rounded-circle mr-1" width="25px" height="25px">
                    {{ $thread->user->name }}
                    @else <img src="{{ asset('images/No_Image_Available.jpg') }}" alt="profile photo" class="rounded-circle mr-1" width="25px" height="25px">
                    <em class="text-danger">Admin</em> @endif</span>
                <span class="text-muted float-right"><small>{{ $thread->createdAtTime() }} &#9679; {{ $thread->created_at }}</small></span>
                <hr>
                <div class="p-2">
                    <p class="thead-body">{!! $thread->body !!}</p>
                </div>
                <hr>
                @if($thread->replies->count())
                @foreach($thread->replies as $reply)
                    <div class="d-flex mt-3">
                        <div class="flex-column ml-2">
                            @if( $reply->user_id ) <img src="{{ $reply->user->profile_photo_path ?? asset('images/No_Image_Available.jpg') }}" class="rounded-circle" width="50px" height="50px">
                            @else <img src="{{ asset('images/No_Image_Available.jpg') }}" alt="profile photo" class="rounded-circle" width="50px" height="50px">
                            @endif
                        </div>
                        <div class="flex-column ml-3">
                            <div class="card @if($reply->is_solution) border-success @else border-0 @endif reply-card">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between">
                                        <h5>
                                            @if( $reply->user_id ) {{ $reply->user->name }}
                                            @else <em class="text-danger">Admin</em>
                                            @endif
                                        </h5>
                                        <div class="dropdown ml-2">
                                            @if($reply->is_solution) <span class="text-success ml-1"><i>solution!</i></span> @endif
                                            <a class="text-secondary" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                <span data-feather="more-horizontal" class="feather-content"></span>
                                            </a>
                                            <div class="dropdown-menu dropdown-menu-sm-left bg-dark border-0" aria-labelledby="dropdownMenuButton">
                                                @can('modify', $thread)
                                                    @if(!$reply->is_solution)
                                                    <form action="{{ route('mark.solution', $reply) }}" method="post">
                                                        @csrf
                                                        <button type="submit" class="dropdown-item text-light dropdown-button">mark as solution</button>
                                                    </form>
                                                    @endif
                                                @endcan
                                                @can('modify', $reply)
                                                <a id="edit" class="dropdown-item text-light dropdown-button" data-target="updateForm{{$loop->iteration}}" data-linked="message{{$loop->iteration}}" data-button="updateButton{{$loop->iteration}}" data-cancel="cancel{{$loop->iteration}}">
                                                    <small>edit</small>
                                                </a>
                                                <form action="{{ route('reply.destroy', ['course'=>$course, 'discussionPanel'=>$discussionPanel, 'thread'=>$thread, 'reply'=>$reply]) }}" method="post">
                                                    @method('DELETE')
                                                    @csrf
                                                    <button type="submit" class="dropdown-item text-light dropdown-button"><small>delete</small></button>
                                                </form>
                                                @endcan
                                                <form action="#" method="post">
                                                    @csrf
                                                    <button type="submit" class="dropdown-item text-danger dropdown-button"><small>report</small></button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                    <span class="text-muted text-light"><small>{{ $reply->createdAtTime() }} &#9679; {{ $reply->created_at }}</small></span>
                                    <p id="message{{$loop->iteration}}" class="mb-0">{{ $reply->message }}</p>
                                    <form id="updateForm{{$loop->iteration}}" action="{{ route('reply.update', ['course'=>$course, 'discussionPanel'=>$discussionPanel, 'thread'=>$thread, 'reply'=>$reply]) }}" method="post">
                                        @method('PUT')
                                        @csrf
                                        <div class="form-group px-0 mx-0 col-md-11">
                                            <textarea name="message" class="form-control reply-card border-0 @error('message') is-invalid @enderror" rows="1" required>{{ old('message') ?? $reply->message }}</textarea>

                                            @error('message')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>
                                    </form>
                                </div>
                            </div>
                            <a id="updateButton{{$loop->iteration}}" type="submit" class="dropdown-button text-primary float-right" onclick="event.preventDefault();
                                                     document.getElementById('updateForm{{$loop->iteration}}').submit();">update</a>
                            <button id="cancel{{$loop->iteration}}" class="dropdown-button float-right">cancel</button>
                        </div>
                    </div>
                @endforeach
                <hr>
                @endif
                <form action="{{ route('reply.store', ['course'=>$course, 'discussionPanel'=>$course->discussionPanel, 'thread'=>$thread]) }}" method="post">
                    @csrf
                    <div class="row">
                        <div class="col-md-1 text-right">
                            <img src="{{ auth()->user()->profile_photo_path ?? asset('images/No_Image_Available.jpg') }}" alt="profile photo" class="rounded-circle" height="50px" width="50px" title="{{ auth()->user()->name }}">
                        </div>
                        <div class="form-group col-md-11">
                            <textarea name="message" class="form-control bg-light @error('message') is-invalid @enderror" rows="2" placeholder="leave a message..." required>{{ old('message') }}</textarea>

                            @error('message')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                    </div>
                    <button type="submit" class="btn btn-block btn-blue"><strong>Reply</strong></button>
                </form>
            </div>
        </div>
        <br>
        <a href="{{ route('thread.index', ['course'=>$course, 'discussionPanel'=>$course->discussionPanel]) }}" class="btn custom btn-light">Back</a>
    </div>
    <script>
        $(function (){
           $('[id*=updateForm]').hide();
           $('[id*=updateButton]').hide();
           $('[id*=cancel]').hide();
        });
        $(document).on('click','#edit',function (){
            var form = $(this).data('target');
            var message = $(this).data('linked');
            var button = $(this).data('button');
            var cancel = $(this).data('cancel');

            $('#'+message).hide();
            $('#'+form).show();
            $('#'+button).show();
            $('#'+cancel).show();
        });
        $(document).on('click','[id*=cancel]',function (){
            $('[id*=updateForm]').hide();
            $('[id*=updateButton]').hide();
            $('[id*=cancel]').hide();
        });
    </script>
@endsection
