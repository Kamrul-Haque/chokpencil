@extends('layouts.app')

@section('content')
    <div class="container py-4">
        <div class="card">
            <div class="card-header">Students Report</div>
            <div class="card-body">
                <div class="table-responsive-lg">
                    <table class="table table-bordered table-striped">
                        <thead class="thead-dark">
                            <tr>
                                <th>#</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Total Marks</th>
                                <th>Average Marks</th>
                                <th>Engagement</th>
                                <th>Course Total Marks</th>
                                <th class="text-center">Assignments</th>
                            </tr>
                        </thead>
                        <tbody>
                        @forelse($students as $student)
                            <tr>
                                <td>{{ $loop->index + 1 }}</td>
                                <td>{{ $student->name }}</td>
                                <td>{{ $student->email }}</td>
                                <td>{{ $student->totalMarks($course) }}</td>
                                <td>{{ $student->avgMarks($course) }}%</td>
                                <td>{{ $student->engagement($course) }}%</td>
                                <td>{{ $course->total_marks }}</td>
                                <td class="text-center">
                                    <a href="{{ route('course.students.assignments',['course'=>$course, 'student'=>$student]) }}">
                                        <span data-feather="folder"></span>
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center">No Records Found</td>
                            </tr>
                        @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="card-footer">
                <div class="d-flex justify-content-between">
                    <div class="flex-column">
                        <a href="{{ route('module.index', $course) }}" class="btn btn-light custom">Back</a>
                    </div>
                    <div class="flex-column">
                        {{ $students->links() }}
                    </div>
                    <div class="flex-column">

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
