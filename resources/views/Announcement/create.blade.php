@extends('layouts.app')

@section('content')
    <div class="container pt-4">
        <div class="card">
            <div class="card-header">
                Create Announcement
            </div>
            <div class="card-body">
                <form method="post" action="{{ route('announcement.store', $course) }}">
                    @csrf
                    <div class="form-group">
                        <label for="message">Announcement Message</label>
                        <textarea id="message" type="text" class="mt-2 form-control @error('message') is-invalid @enderror" name="message" required>{{ old('message') ?? '' }}</textarea>

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
                        <a href="{{ route('module.index', $course) }}" class="btn custom btn-light">Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
