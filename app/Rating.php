<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Rating extends Model
{
    use SoftDeletes;

    protected $guarded = [];

    //returns the date in custom format
    public function getDateAttribute($value)
    {
        $carbon = new Carbon($value);
        return $carbon->format('d/m/Y');
    }

    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
