<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Enquiry extends Model
{
    use SoftDeletes;

    protected $guarded = [];

    public function course()
    {
        return $this->belongsTo(Course::class);
    }
}
