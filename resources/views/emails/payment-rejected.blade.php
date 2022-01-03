@component('mail::message')
# Payment Rejected

Dear {{ $payment->user->name }},

You payment of <strong>{{ $payment->amount }}</strong> for "{{ $payment->course->title }}" has been <strong>rejected</strong>. The payment information does not match our records. Please try again or contact support.

Thanks,<br>
{{ config('app.name') }}
@endcomponent
