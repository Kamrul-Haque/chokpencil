<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Content extends Model
{
    use SoftDeletes;

    protected $guarded = [];

    //returns an accessible http url for the asset from the storage path stored in database
    public function getFilePathAttribute($value)
    {
        if ($value) {
            return asset($value);
        }
    }

    //parses the stored url to get only the video key needed for embedded player
    public function getVideoLinkAttribute($value)
    {
        if (strlen($value) > 11) {
            if (preg_match('%(?:youtube(?:-nocookie)?\.com/(?:[^/]+/.+/|(?:v|e(?:mbed)?)/|.*[?&]v=)|youtu\.be/)([^"&?/ ]{11})%i', $value, $match)) {
                return $match[1];
            } else
                return false;
        }

        return $value;
    }

    public function module()
    {
        return $this->belongsTo(Module::class);
    }

    public function threads()
    {
        return $this->hasMany(Thread::class);
    }

    public function notes()
    {
        return $this->hasMany(Note::class);
    }
}
