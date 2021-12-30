@extends('layouts.app')

@section('content')
    <div class="container py-4">
        <div class="card">
            <div class="card-header">
                Admins
            </div>
            <div class="card-body">
                @if($admins->count()>0)
                    <div class="table-responsive-lg">
                        <table class="table table-bordered table-striped">
                            <thead class="thead-dark">
                            <tr>
                                <th>#</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Job Title</th>
                                <th>Phone</th>
                                <th class="text-center">Operations</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($admins as $admin)
                                <tr>
                                    <td>{{ $loop->index+1 }}</td>
                                    <td> {{ $admin->user->name }} </td>
                                    <td> {{ $admin->user->email }} </td>
                                    <td> {{ $admin->job_title }} </td>
                                    <td> {{ $admin->phone }} </td>
                                    <td>
                                        <div class="row justify-content-center">
                                            <div class="pl-1">
                                                <a class="btn btn-primary btn-sm" href="{{ route('admin.admin.edit', $admin) }}" title="edit"><span data-feather="edit" style="height: 15px; width: 15px; padding: 0"></span></a>
                                            </div>
                                            <form class="pl-1" action="{{ route('admin.admin.destroy', $admin) }}" method="post">
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
                        <a href="{{ route('dashboard') }}" class="btn btn-light custom">Back</a>
                    </div>
                    <div class="col-sm-4 d-flex justify-content-center">
                        {{ $admins->links() }}
                    </div>
                    <div class="col-sm-4">
                        <a href="{{ route('admin.admin.create') }}" class="btn custom btn-success float-right">Create</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
