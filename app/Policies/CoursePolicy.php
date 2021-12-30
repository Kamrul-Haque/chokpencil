<?php

namespace App\Policies;

use App\Course;
use App\Response;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class CoursePolicy
{
    use HandlesAuthorization;

    public function create(User $user)
    {
        if ($user->hasRole('admin'))
            return true;
        else if($user->hasRole('instructor') && $user->instructor->is_verified)
            return true;
        else
            return false;
    }

    public function modify(User $user, Course $course)
    {
        if ($user->hasRole('admin'))
            return true;
        else if($user->hasRole('instructor'))
            return $course->instructors->contains($user);
        else
            return false;
    }

    public function assignInstitution(User $user, Course $course)
    {
        if($user->hasRole('admin'))
        {
            if (!$course->institution)
                return true;
            else
                return $this->deny('Institution is already assigned.');
        }
    }

    public function leaveCourse(User $user, Course $course)
    {
        if($user->hasRole('instructor'))
            return $course->instructors->contains($user);
    }

    public function enroll(User $user, Course $course)
    {
        if($user->hasRole('student'))
        {
            if (!$course->students->contains($user))
                return true;
        }
    }

    public function access(User $user, Course $course)
    {
        if ($user->hasRole('admin'))
            return true;
        else if($user->hasRole('instructor'))
            return $course->instructors->contains($user);
        else if($user->hasRole('student'))
        {
            if ($course->students->contains($user))
                return true;
            else
                return $this->deny('You need to Enroll first!', redirect()->route('course.show', $course));
        }
        else
            return false;
    }

    public function wishlist(User $user, Course $course)
    {
        if ($this->enroll($user, $course))
        {
            if (!($course->wishlists()->where('user_id', $user->id)->first()))
                return true;
        }
    }

    public function removeWishlist(User $user, Course $course)
    {
        if ($this->enroll($user, $course))
        {
            if ($course->wishlists()->where('user_id', $user->id)->first())
                return true;
        }
    }

    public function rate(User $user, Course $course)
    {
        if ($user->hasRole('student'))
            return $course->students->contains($user);
    }
}
