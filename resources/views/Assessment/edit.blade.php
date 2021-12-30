@extends('layouts.app')

@section('styles')
    <style>
        .container{
            width: 50%;
        }
        label{
            font-size: large;
        }
    </style>
@endsection

@section('content')
    <div class="container py-4">
        <div class="card">
            <div class="card-header">
                Edit Assessment
            </div>

            <div class="card-body">
                <form method="POST" action="{{ route('assessment.update', ['course'=>$course,'module'=>$module,'assessment'=>$assessment]) }}" enctype="multipart/form-data">
                    @method('PUT')
                    @csrf
                    <div class="pl-4 pr-4 pt-1">
                        <div class="form-group">
                            <label for="title">Title</label>

                            <input id="title" type="text" class="form-control @error('title') is-invalid @enderror" name="title" value="{{ $assessment->title }}" required autofocus>

                            @error('title')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>

                        <div id="editor" class="form-group">
                            <label for="description">Description</label>

                            <textarea id="description" class="form-control editor @error('description') is-invalid @enderror" name="description" rows="5">{{ $assessment->description }}</textarea>

                            @error('description')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>

                        <div id="attachment-file" class="form-group pt-3">
                            <label for="file-group">Attachment File</label>

                            <div id="file-group" class="custom-file">
                                <input id="attachment" name="attachment" type="file" class="custom-file-input @error('attachment') is-invalid @enderror">
                                <label for="attachment" class="custom-file-label">File Name</label>

                                @error('attachment')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="deadline">Deadline</label>

                            <input id="deadline" type="date" class="form-control @error('deadline') is-invalid @enderror" name="deadline" value="{{ $assessment->deadline }}">

                            @error('deadline')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>

                        <div id="peer-group" class="form-group">
                            <div class="form-check">
                                <input id="peer" name="peer" type="checkbox" class="form-check-input @error('peer') is-invalid @enderror" {{ ($assessment->peer_graded) ? 'checked' : '' }}>
                                <label for="peer" class="form-check-label">this assessment is peer graded.</label>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="">
                                <button type="submit" class="btn custom btn-primary">
                                    Update
                                </button>
                                <a href="{{ route('module.index', $course) }}" class="btn custom btn-light">Cancel</a>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
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
