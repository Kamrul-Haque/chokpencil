<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Admin extends Model
{
    use SoftDeletes;

    //returns the date in custom format
    public function getDobAttribute($value)
    {
        $carbon = new Carbon($value);
        return $carbon->format('d/m/Y');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
