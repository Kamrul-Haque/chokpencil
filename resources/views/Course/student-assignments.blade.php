@extends('layouts.app')

@section('content')
    <div class="container py-4">
        <div class="card">
            <div class="card-header">Assignments of {{ $student->name }}</div>
            <div class="card-body">
               <div class="px-2">
                   @forelse($responses as $response)
                       <h4>{{ $response->question->question }}</h4>
                       <h5>Answer:</h5>
                       @if($response->responseAnswers->first()->attachment_path)
                           <div class="d-flex justify-content-center border p-3">
                               <span data-feather="file-text"></span>
                               <a href="{{ $response->responseAnswers->first()->attachment_path }}" class="pl-1">{{ basename($response->responseAnswers->first()->attachment_path) }}</a>
                           </div>
                       @elseif($response->question->type == 'Descriptive')
                           <h5>{!! $response->responseAnswers->first()->answer !!}</h5>
                       @elseif($response->question->type == 'Link Submission')
                           <a href="{{ $response->responseAnswers->first()->answer }}" class="link">{{ $response->responseAnswers->first()->answer }}</a>
                           <br>
                       @else
                           @foreach($response->responseAnswers as $answer)
                               <li class="ml-3">{{ $answer->answer }}</li>
                           @endforeach
                       @endif
                       <br>
                       <span class="font-weight-bold">Marks Obtained: {{ $response->where('user_id',$student->id)->first()->obtained_marks ?? 'Pending Review' }}</span>
                       <hr>
                   @empty
                       <h5 class="text-center">Nothing Submitted Yet.</h5>
                   @endforelse
               </div>
            </div>
            <div class="card-footer">
                <div class="d-flex justify-content-between">
                    <div class="flex-column">
                        <a href="{{ route('course.students.report', $course) }}" class="btn custom btn-light">Back</a>
                    </div>
                    <div class="flex-column justify-content-center">
                        {{--<span>{{ $responses->links() }}</span>--}}
                    </div>
                    <div class="flex-column">

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script type='text/javascript'>
        $(function(){
            $('.card-body>div>hr:last-child').remove();
        });
    </script>
@endsection
