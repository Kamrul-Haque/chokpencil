<?php

namespace App\Policies;

use App\Thread;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ThreadPolicy
{
    use HandlesAuthorization;

    public function modify(User $user, Thread $thread)
    {
        return $thread->user->is($user);
    }
}
