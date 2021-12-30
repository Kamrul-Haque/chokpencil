@extends('layouts.app')

@section('content')
    <div class="container pt-4">
        <div class="card">
            <div class="card-header">
                Edit Post
            </div>
            <div class="card-body">
                <form method="post" action="{{ route('thread.update', ['course'=>$course,'discussionPanel'=>$discussionPanel, 'thread'=>$thread]) }}">
                    @method('PUT')
                    @csrf
                    <div class="form-group">
                        <label for="subject">Subject</label>
                        <input type="text" id="subject" name="subject" class="form-control @error('subject') is-invalid @enderror" value="{{ old('subject') ?? $thread->subject }}" required>

                        @error('subject')
                        <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="message">Message</label>
                        <textarea id="message" type="text" class="mt-2 editor form-control @error('message') is-invalid @enderror" name="message" required>{!!  old('message') ?? $thread->body !!}</textarea>

                        @error('message')
                        <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <button type="submit" class="btn custom btn-primary">
                            Update
                        </button>
                        <a href="{{ route('thread.show', ['course'=>$course,'discussionPanel'=>$discussionPanel, 'thread'=>$thread]) }}" class="btn custom btn-light">Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
