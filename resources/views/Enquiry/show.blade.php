@extends('layouts.app')

@section('content')
    <div class="container py-4">
        <div class="card">
            <div class="card-header">Enquiry</div>
            <div class="card-body">
                <h5><strong>Name: </strong>{{ $enquiry->name }}</h5>
                <h5><strong>Email: </strong>{{ $enquiry->email }}</h5>
                @if($enquiry->course) <h5><strong>About Course: </strong>{{ $enquiry->course->title }}</h5> @endif
                <hr>
                {!! $enquiry->enquiry !!}
                <hr>
                <form action="{{ route('admin.enquiry.reply', $enquiry) }}" method="post">
                    @csrf
                    <div class="form-group">
                        <label for="subject">Subject</label>
                        <input type="text" id="subject" name="subject" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="reply">Body</label>
                        <textarea id="reply" name="reply" rows="5" class="form-control"></textarea>
                    </div>
                    <button type="submit" class="btn btn-block btn-primary">Reply</button>
                </form>
            </div>
            <div class="card-footer">
                <div class="d-flex justify-content-between">
                    <div class="col-sm-4">
                        <a href="{{ route('dashboard') }}" class="btn custom btn-light">Back</a>
                    </div>
                    <div class="col-sm-4">

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
