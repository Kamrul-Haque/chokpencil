@extends('layouts.app')

@section('content')
    <div class="container py-4">
        <div class="card">
            <div class="card-header">
                Change Awarding Body
            </div>
            <div class="card-body">
                <form action="{{ route('admin.course.institution.store',$course) }}" method="post">
                    @csrf
                    <div class="form-group">
                        <label for="institution">Institution</label>
                        <select name="institution" id="institution" class="form-control" required>
                            <option value="" selected disabled>Please Select...</option>
                            @foreach($institutions as $institution)
                                <option value="{{ $institution->id }}">{{ $institution->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn custom btn-dark">Assign</button>
                        <a href="{{ route('course.show', $course) }}" class="btn custom btn-light">Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
