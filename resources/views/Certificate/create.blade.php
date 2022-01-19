@extends('layouts.app')

@section('content')
    <div class="container py-4">
        <div class="d-flex justify-content-center">
            <div class="card">
                <div class="card-header">Issue Certificate</div>
                <div class="card-body">
                    <p>The Institution, the course is assigned to will ensure the credibility or authenticity of the certification.
                        <br>The platform will not bear any responsibilities in this regard.</p>
                    <form action="{{ route('certificate.store', $course) }}" method="post">
                        @csrf
                        <button type="submit" class="btn btn-sm btn-primary custom float-right">I Agree</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
