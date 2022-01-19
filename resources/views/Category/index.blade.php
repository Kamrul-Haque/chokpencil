@extends('layouts.app')

@section('content')
    <div class="container-fluid px-md-5 py-4">
        <div class="card">
            <div class="card-body">
                <div class="card-title">
                    Categories
                </div>
                @if($categories->count())
                    <div class="table-responsive-lg">
                        <table class="table">
                            <thead class="font-weight-bolder">
                            <tr>
                                <th>#</th>
                                <th>Image</th>
                                <th>Category Name</th>
                                <th class="text-center">Operations</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($categories as $category)
                                <tr>
                                    <td>{{ $loop->index+1 }}</td>
                                    <td><img src="{{ $category->image }}" alt="" width="auto" height="35px"></td>
                                    <td>{{ $category->name }}</td>
                                    <td>
                                        <div class="d-flex justify-content-center">
                                            <div class="flex-column pl-1">
                                                <a class="btn btn-primary btn-sm" href="{{ route('admin.category.edit', $category) }}" title="edit"><span data-feather="edit" style="height: 15px; width: 15px; padding: 0"></span></a>
                                            </div>
                                            <form class="flex-column pl-1" action="{{ route('admin.category.destroy', $category) }}" method="post">
                                                @method('DELETE')
                                                @csrf
                                                <button type="submit" class="btn btn-danger btn-sm" title="delete"><span data-feather="trash-2" style="height: 15px; width: 15px; padding: 0"></span></button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <h4 class="d-flex justify-content-center">NO RECORDS FOUND</h4>
                @endif
                <div class="d-flex justify-content-between">
                    <div class="flex-column">
                        {{ $categories->links() }}
                    </div>
                    <div class="flex-column">
                        <a href="{{ route('admin.category.create') }}" class="btn custom btn-dark">Create</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
