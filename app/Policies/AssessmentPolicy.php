<?php

namespace App\Policies;

use App\Assessment;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class AssessmentPolicy
{
    use HandlesAuthorization;

    public function before(User $user)
    {
        if ($user->hasRole('admin') || $user->hasRole('instructor'))
            return true;
    }

    public function view(User $user, Assessment $assessment)
    {
        if ($user->hasRole('student'))
            if ($assessment->is_published)
                return true;

        return false;
    }
}
