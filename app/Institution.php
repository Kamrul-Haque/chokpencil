<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Institution extends Model
{
    use SoftDeletes;

    protected $guarded = [];

    //returns an accessible http url for the asset from the storage path stored in database
    public function getLogoPathAttribute($value)
    {
        if ($value)
        {
            return asset($value);
        }
    }

    public function courses()
    {
        $this->hasMany(Course::class);
    }

    public function instructors()
    {
        $this->hasMany(Instructor::class);
    }
}
