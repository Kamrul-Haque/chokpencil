@extends('layouts.app')

@section('content')
    <div class="container py-5">
        <h4 class="text-center"><strong>All Notifications</strong></h4>
        @if(auth()->user()->notifications->count())
            <div class="custom border my-3 py-3 bg-light shadow rounded">
                @foreach(auth()->user()->notifications as $notification)
                    <h5 class="dropdown-item" @if($notification->read_at == null) style="font-weight: 900" @endif>
                        @if($notification->type === \App\Notifications\PaymentReceived::class)
                            Your Payment of {{ $notification->data['amount'] }} for {{ $notification->data['course'] }}
                            <br>has been received. Check email for details.
                        @elseif($notification->type === \App\Notifications\PaymentConfirmed::class)
                            Your Payment for {{ $notification->data['course'] }} has been confirmed. You are now enrolled into the course.
                        @elseif($notification->type === \App\Notifications\AccountVerified::class)
                            Your account has been verified. You can now teach in our platform.
                        @elseif($notification->type === \App\Notifications\Enrolled::class)
                            You have been enrolled into the course {{ $notification->data['course'] }}.
                        @endif
                    </h5>
                    <hr>
                @endforeach
            </div>
        @else
            <div class="custom border my-3 py-3 bg-light shadow rounded">
                <h5 class="text-center my-2">No Notifications Yet.</h5>
            </div>
        @endif
        <a href="{{ url()->previous() }}" class="btn custom btn-light">Back</a>
    </div>
@endsection

@section('scripts')
    <script type='text/javascript'>
        $(function(){
            $('.custom>hr:last-child').remove();
        });
    </script>
@endsection
