@component('mail::message')
# Reply to Enquiry

Dear {{ $enquiry->name }},<br>
This is a response to your enquiry:<br>
<p class="quote quote-primary">{{ $enquiry->enquiry }}</p>

{!! $reply !!}

Thanks,<br>
{{ config('app.name') }}
@endcomponent
