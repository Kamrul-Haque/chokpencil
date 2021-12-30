@extends('layouts.app')

@section('content')
    <div class="container pt-4">
        <div class="card">
            <div class="card-header">
                Create Post
            </div>
            <div class="card-body">
                <form method="post" action="{{ route('thread.store', ['course'=>$course,'discussionPanel'=>$discussionPanel]) }}">
                    @csrf
                    <div class="form-group">
                        <label for="select">Content</label>
                        <select id="select" name="select" id="" class="form-control" required>
                            <option value="" disabled selected>Please Select...</option>
                            <option value="0">General Discussion</option>
                            @foreach($course->modules as $module)
                                <option value="" disabled>{{ $module->module_name }}</option>
                                @foreach($module->contents as $content)
                                    <option value="{{ $content->id }}">&nbsp;&nbsp;{{ $content->title }}</option>
                                @endforeach
                            @endforeach
                        </select>
                    </div>
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
                        <button type="submit" class="btn custom btn-primary">
                            Create
                        </button>
                        <a href="{{ route('thread.index', ['course'=>$course,'discussionPanel'=>$discussionPanel]) }}" class="btn custom btn-light">Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
