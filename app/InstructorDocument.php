<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class InstructorDocument extends Model
{
    protected $guarded = [];

    public function instructor()
    {
        return $this->belongsTo(Instructor::class);
    }
}
