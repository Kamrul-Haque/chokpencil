<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DiscussionPanel extends Model
{
    protected $guarded = [];

    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    public function threads()
    {
        return $this->hasMany(Thread::class);
    }
}
