@extends('layouts.app')

@section('content')
    <div class="container p-4">
        <div class="d-flex justify-content-center">
            <div class="card w-75">
                <div class="card-header">
                    Students
                </div>
                <div class="card-body">
                    @if($students->count() > 0)
                        <div class="table-responsive-lg">
                            <table class="table table-striped table-bordered">
                                <thead class="thead thead-dark">
                                <tr>
                                    <th>#</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Study Level</th>
                                    <th>Operations</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($students as $student)
                                    <tr>
                                        <td> {{ $loop->index + 1 }} </td>
                                        <td> {{ $student->name }} </td>
                                        <td> {{ $student->email }} </td>
                                        <td> {{ $student->study_level }} </td>
                                        <td>
                                            <div class="row justify-content-center">
                                                <form class="pl-1" action="{{ route('admin.user.destroy', $student) }}" method="post">
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
                            {{ $students->links() }}
                        </div>
                        <div class="col-sm-4">
                            <a href="{{ route('admin.user.create') }}" class="btn custom btn-success float-right">Create</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
