@extends('layouts.app')

@section('content')
    <div class="container py-4">
        <div class="card">
            <div class="card-header">
                Instructors
            </div>
            <div class="card-body">
                @if($instructors->count() > 0)
                    <div class="table-responsive-lg">
                        <table class="table table-striped table-bordered">
                            <thead class="thead thead-dark">
                            <tr>
                                <th>#</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Phone</th>
                                <th>Qualification</th>
                                <th>Designation</th>
                                <th>Department</th>
                                <th>Institution</th>
                                <th>Verified</th>
                                <th>Operations</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($instructors as $instructor)
                                <tr>
                                    <td> {{ $loop->index+1 }} </td>
                                    <td> {{ $instructor->user->name }} </td>
                                    <td> {{ $instructor->user->email }} </td>
                                    <td> {{ $instructor->phone }} </td>
                                    <td> {{ $instructor->qualification }} </td>
                                    <td> {{ $instructor->designation }} </td>
                                    <td> {{ $instructor->department }} </td>
                                    <td> {{ $instructor->institution }} </td>
                                    <td> @if($instructor->is_verified) true @else false @endif </td>
                                    <td>
                                        <div class="row justify-content-center">
                                            <a href="{{ route('admin.instructor.show', $instructor) }}" class="btn btn-dark btn-sm" title="view"><span data-feather="eye" style="height: 15px; width: 15px; padding: 0"></span></a>
                                            <form class="pl-1" action="{{ route('admin.instructor.destroy', $instructor) }}" method="post">
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
            </div>
            <div class="card-footer">
                <div class="row">
                    <div class="col-sm-4">
                        <a href="{{ route('dashboard') }}" class="btn custom btn-light">Back</a>
                    </div>
                    <div class="col-sm-4 d-flex justify-content-center">
                        {{ $instructors->links() }}
                    </div>
                    <div class="col-sm-4">
                        <a href="{{ route('admin.instructor.create') }}" class="btn custom btn-success float-right">Create</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
