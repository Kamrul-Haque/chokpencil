@component('mail::message')
# Payment Received

Dear {{ $payment->user->name }},

Your payment for <strong>{{ $payment->course->title }}</strong> has been received successfully. You can access the Course Contents as soon as the payment is <strong>confirmed</strong>. Please keep patience until then. You will be notified upon payment confirmation.

### Payment Details:
@component('mail::table')
| Category       | Value                        |
|:---------------|:-----------------------------|
| Payment ID     | #{{$payment->id}}            |
| Method         | {{$payment->method}}         |
| Account No.    | {{$payment->account_no}}     |
| Amount         | {{$payment->amount}}         |
| Transaction ID | {{$payment->transaction_id}} |
| Reference      | {{$payment->reference}}      |
@endcomponent

You can edit the payment information only <em class="text-danger">once</em> in case you made mistake.

@component('mail::button', ['url' => route('payment.edit', ['course'=>$payment->course,'payment'=>$payment])])
Edit Payment Information
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
