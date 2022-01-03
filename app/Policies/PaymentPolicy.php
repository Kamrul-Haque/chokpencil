<?php

namespace App\Policies;

use App\Course;
use App\Payment;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class PaymentPolicy
{
    use HandlesAuthorization;

    public function create(User $user, Course $course)
    {
        if (auth()->user()->hasRole('student'))
        {
            if (!($course->payments()->where('user_id', $user->id)->first()))
                return true;
            elseif ($course->payments()->where('user_id', $user->id)->where('needs_verification',false)->where('is_verified',false)->first())
                return true;
            else return $this->deny('You have already paid for the course!');
        }
    }

    public function update(User $user, Payment $payment)
    {
        if (auth()->user()->hasRole('student'))
        {
            if (!$payment->is_edited)
                return true;
            else return $this->deny('You can edit payment information only once.');
        }
    }
}
