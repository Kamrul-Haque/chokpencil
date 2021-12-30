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
    <div class="container p-4">
        <div class="card">
            <div class="card-header">
                Edit Content
            </div>

            <div class="card-body">
                <form method="POST" action="{{ route('content.update', ['course'=>$course,'module'=>$module,'content'=>$content]) }}" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="pl-4 pr-4 pt-1">
                        <div class="form-group">
                            <label for="title">Title</label>

                            <input id="title" type="text" class="form-control @error('title') is-invalid @enderror" name="title" value="{{ $content->title }}" required autofocus>

                            @error('title')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>

                        <div id="group" class="form-group">
                            <label for="type">Type</label>

                            <select id="type" name="type" type="text" class="form-control @error('type') is-invalid @enderror" required>
                                <option value="" selected disabled>Please Select...</option>
                                <option value="Text" @if( $content->type == "Text") selected @endif>Text</option>
                                <option value="Link" @if( $content->type == "Link") selected @endif>Link</option>
                                <option value="Video" @if( $content->type == "Video") selected @endif>Video</option>
                                <option value="File" @if( $content->type == "File") selected @endif>File</option>
                            </select>

                            @error('type')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>

                        <div id="editor" class="form-group">
                            <label for="description">Description</label>

                            <textarea id="description" class="form-control editor @error('description') is-invalid @enderror" name="description" rows="5">{{ $content->description }}</textarea>

                            @error('description')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>

                        <div id="web-link" class="form-group">
                            <label for="link">Link</label>

                            <input id="link" type="text" class="form-control @error('link') is-invalid @enderror" name="link" value="{{ $content->web_link }}">

                            @error('link')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>

                        <div id="video-link" class="form-group">
                            <label for="video">Video Link</label>

                            <input id="video" type="text" class="form-control @error('video') is-invalid @enderror" name="video" placeholder="youtube or vimeo url" value="{{  $content->getOriginal('video_link') }}">

                            @error('video')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>

                        <div id="content-file" class="form-group">
                            <label for="file-group">Content File</label>

                            <div id="file-group" class="custom-file">
                                <input id="file" name="file" type="file" class="custom-file-input @error('file') is-invalid @enderror">
                                <label for="file" class="custom-file-label">File Name</label>

                                @error('file')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="form-check">
                                <input id="protected" name="protected" type="checkbox" class="form-check-input @error('protected') is-invalid @enderror" {{ ($content->is_protected) ? 'checked' : '' }}>
                                <label for="protected" class="form-check-label">the file is protected</label>
                            </div>

                            @error('protected')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
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
        $(function (){
            if ( $('#type').val() == "Link" ){
                $('#web-link').show();
                $('#video').val(null);
                $('#video-link').hide();
                $('#file').val(null);
                $('#content-file').hide();
            }
            else if ( $('#type').val() == "Video" ){
                $('#video-link').show();
                $('#file').val(null);
                $('#content-file').hide();
                $('#link').val(null);
                $('#web-link').hide();
            }
            else if( $('#type').val() == "File" ){
                $('#content-file').show();
                $('#video').val(null);
                $('#video-link').hide();
                $('#link').val(null);
                $('#web-link').hide();
            }
            else {
                $('#video').val(null);
                $('#video-link').hide();
                $('#file').val(null);
                $('#content-file').hide();
                $('#link').val(null);
                $('#web-link').hide();
            }
        });
        $('#type').on('change',function (){
            if ( $(this).val() == "Link" ){
                $('#web-link').show();
                $('#video').val(null);
                $('#video-link').hide();
                $('#file').val(null);
                $('#content-file').hide();
            }
            else if ( $(this).val() == "Video" ){
                $('#video-link').show();
                $('#file').val(null);
                $('#content-file').hide();
                $('#link').val(null);
                $('#web-link').hide();
            }
            else if( $(this).val() == "File" ){
                $('#content-file').show();
                $('#video').val(null);
                $('#video-link').hide();
                $('#link').val(null);
                $('#web-link').hide();
            }
            else {
                $('#video').val(null);
                $('#video-link').hide();
                $('#file').val(null);
                $('#content-file').hide();
                $('#link').val(null);
                $('#web-link').hide();
            }
        });
        $(".custom-file-input").on("change", function() {
            var fileName = $(this).val().split("\\").pop();
            $(this).siblings(".custom-file-label").addClass("selected").html(fileName);
        });
    </script>
@endsection
