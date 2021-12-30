@component('mail::message')
# Payment Confirmed

Dear {{ $payment->user->name }},

You payment of <strong>{{ $payment->amount }}</strong> for {{ $payment->course->title }} has been <strong>confirmed</strong>. You can now access the course contents through the link given below or from your dashboard.

@component('mail::button', ['url' => route('module.index', $payment->course)])
Course Contents
@endcomponent

Thanks for your Patience. Happy Learning!
@endcomponent
