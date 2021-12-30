<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{
    use SoftDeletes;

    protected $guarded = [];

    //returns an accessible http url for the asset from the storage path stored in database
    public function getImageAttribute($value)
    {
        if ($value)
        {
            return asset($value);
        }
    }

    public function courses()
    {
        return $this->hasMany(Course::class);
    }
}
