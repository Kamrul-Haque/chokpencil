@component('mail::message')
# Account Verified

Congratulations! You have been <strong>verified</strong> as an instructor in our platform. You can now now create your own courses or your fellow instructors can add you in an existing course.

@component('mail::button', ['url' => '/course/create'])
Create Course
@endcomponent

Enjoy Enlightening Others,<br>
{{ config('app.name') }}.
@endcomponent
