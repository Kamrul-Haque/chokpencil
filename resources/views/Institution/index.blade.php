@extends('layouts.app')

@section('content')
    <div class="container py-4">
        <div class="card">
            <div class="card-header">
                Institutions
            </div>
            <div class="card-body">
                @if($institutions->count()>0)
                    <div class="table-responsive-lg">
                        <table class="table table-bordered table-striped">
                            <thead class="thead-dark">
                            <tr>
                                <th>#</th>
                                <th>Logo</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Phone</th>
                                <th>Address</th>
                                <th>Education Level</th>
                                <th>Operations</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($institutions as $institution)
                                <tr>
                                    <td>{{ $loop->index+1 }}</td>
                                    <td>
                                        <img src="{{ $institution->logo_path }} " alt="logo" height="35px" width="auto">
                                    </td>
                                    <td> {{ $institution->name }} </td>
                                    <td> {{ $institution->email }} </td>
                                    <td> {{ $institution->phone }} </td>
                                    <td> {{ $institution->address }} </td>
                                    <td> {{ $institution->study_level_lower }} - {{ $institution->study_level_upper }} </td>
                                    <td>
                                        <div class="row justify-content-center">
                                            <div class="pl-1">
                                                <a class="btn btn-primary btn-sm" href="{{ route('admin.institution.edit', $institution) }}" title="edit"><span data-feather="edit" style="height: 15px; width: 15px; padding: 0"></span></a>
                                            </div>
                                            <form class="pl-1" action="{{ route('admin.institution.destroy', $institution) }}" method="post">
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
                        {{ $institutions->links() }}
                    </div>
                    <div class="col-sm-4">
                        <a href="{{ route('admin.institution.create') }}" class="btn custom btn-success float-right">Create</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
