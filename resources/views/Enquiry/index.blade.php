@extends('layouts.app')

@section('content')
    <div class="container py-4">
        <div class="card">
            <div class="card-header">Enquiries</div>
            <div class="card-body">
                @if($enquiries->count())
                <div class="table-responsive-lg">
                    <table class="table table-bordered table-striped">
                        <thead class="thead thead-dark">
                            <tr>
                                <th>#</th>
                                <th>User Name</th>
                                <th>User Email</th>
                                <th>User Phone</th>
                                <th>Course</th>
                                <th>Subject</th>
                                <th>Message</th>
                                <th class="text-center">Operations</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($enquiries as $enquiry)
                            <tr>
                                <td>{{ $loop->index + 1 }}</td>
                                <td>{{ $enquiry->name }}</td>
                                <td>{{ $enquiry->email }}</td>
                                <td>{{ $enquiry->phone }}</td>
                                <td>{{ ($enquiry->course) ? $enquiry->course->title : 'N/A' }}</td>
                                <td>{{ $enquiry->subject }}</td>
                                <td>
                                    <div class="d-flex justify-content-center">
                                        <a href="{{ route('admin.enquiry.show', $enquiry) }}" class="btn btn-dark btn-sm">
                                            <span data-feather="eye" style="height: 15px; width: 15px; padding: 0"></span>
                                        </a>
                                    </div>
                                </td>
                                <td>
                                    <div class="d-flex justify-content-center">
                                        <form action="{{ route('admin.enquiry.destroy', $enquiry) }}" method="post">
                                            @method('DELETE')
                                            @csrf
                                            <button type="submit" class="btn btn-danger btn-sm">
                                                <span data-feather="trash-2" style="height: 15px; width: 15px; padding: 0"></span>
                                            </button>
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
                        {{ $enquiries->links() }}
                    </div>
                    <div class="col-sm-4">

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
