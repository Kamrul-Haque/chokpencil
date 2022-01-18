@extends('layouts.app')

@section('content')
    <div class="container py-4">
        <div class="d-flex justify-content-center">
            <div class="card w-50">
                <div class="card-body">
                    <div class="card-title">Enroll Students</div>
                    <form action="{{ route('interests.store') }}" method="post">
                        @csrf
                        <div class="table-responsive-lg">
                            <table class="table border-bottom-0">
                                <thead class="font-weight-bolder">
                                <tr>
                                    <th>#</th>
                                    <th class="text-center">Select</th>
                                    <th>Name</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($categories as $category)
                                    <tr>
                                        <td>
                                            {{ $loop->index + 1 }}
                                        </td>
                                        <td class="text-center">
                                            <input id="interest" type="checkbox" name="interests[]" class="form-check-inline" value="{{ $category->id }}" {{ auth()->user()->interests->contains('category', $category) ? 'checked' : ''}}>
                                        </td>
                                        <td>
                                            <p>{{ $category->name }}</p>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                        <hr>
                        <button type="submit" class="btn custom btn-dark float-right">Save</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
