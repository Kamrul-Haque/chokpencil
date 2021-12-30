@component('mail::message')
# Course Resources

Dear {{ $notifiable->name }},

You have been enrolled to <strong>{{ $course->title }}</strong>. You can now access the course contents through the link given below or from your dashboard.

@component('mail::button', ['url' => route('module.index', $course)])
    Course Contents
@endcomponent

Happy Learning!
@endcomponent
