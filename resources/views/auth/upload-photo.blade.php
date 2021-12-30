@extends('layouts.app')

@section('content')
    <div class="container py-4">
        <div class="d-flex justify-content-center">
            <div class="card w-50 shadow-sm">
                <div class="card-header">
                    Image Upload
                </div>
                <div class="card-body">
                    <form action="{{ route('photo.upload', $user) }}" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                            <label for="image_file">Profile image</label>

                            <div id="image_file" class="custom-file">
                                <input id="image" name="image" type="file" class="custom-file-input @error('image') is-invalid @enderror" required>
                                <label for="image" class="custom-file-label">Image Name</label>

                                @error('image')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="">
                                <button type="submit" class="btn custom btn-primary">
                                    Upload
                                </button>
                                <a href="{{ route('profile') }}" class="btn custom btn-light">Cancel</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script type="text/javascript">
        $(".custom-file-input").on("change", function() {
            var fileName = $(this).val().split("\\").pop();
            $(this).siblings(".custom-file-label").addClass("selected").html(fileName);
        });
    </script>
@endsection
