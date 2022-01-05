@extends('layouts.app')

@section('content')
    <div class="container py-4">
        <div class="d-flex justify-content-center">
            <div class="card w-50">
                <div class="card-header">Enroll Students</div>
                <div class="card-body">
                    <form action="{{ route('admin.course.enroll.students', $course) }}" method="post">
                        @csrf
                        <div class="table-responsive-lg">
                            <table class="table table-bordered table-striped">
                                <thead class="thead-dark">
                                <tr>
                                    <th>#</th>
                                    <th class="text-center">Select</th>
                                    <th>Email</th>
                                    <th>Name</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($students as $student)
                                    <tr>
                                        <td>
                                            {{ $loop->index + 1 }}
                                        </td>
                                        <td class="text-center">
                                            <input id="student" type="checkbox" name="student[]" class="form-check-inline" value="{{ $student->id }}" {{ $course->students->contains($student) ? 'checked' : ''}}>
                                        </td>
                                        <td>
                                            <label for="student" class="form-check-label">{{ $student->email }}</label>
                                        </td>
                                        <td>
                                            <p>{{ $student->name }}</p>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                        <hr>
                        <a href="{{ route('course.show', $course) }}" class="btn custom btn-light">Cancel</a>
                        <button type="submit" class="btn custom btn-dark">Enroll</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
