@extends('layouts.app')

@section('content')
    <div class="container py-4">
        <div class="d-flex justify-content-center">
            <div class="card w-50">
                <div class="card-header">
                    Create Category
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.category.store') }}" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                            <label for="name">Category Name</label>
                            <input type="text" id="name" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}" required>
                            @error('name') <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span> @enderror
                        </div>
                        <div class="form-group">
                            <label for="image_file">Category image</label>

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
                            <button type="submit" class="btn custom btn-dark">Create</button>
                            <a href="{{ route('admin.category.index') }}" class="btn custom btn-light">Cancel</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
