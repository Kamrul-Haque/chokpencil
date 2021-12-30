<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Question extends Model
{
    use SoftDeletes;

    protected $guarded = [];

    public function assessment()
    {
        return $this->belongsTo(Assessment::class);
    }

    public function answers()
    {
        return $this->hasMany(Answer::class);
    }

    public function responses()
    {
        return $this->hasMany(Response::class);
    }

    public function responseAnswers()
    {
        return $this->hasManyThrough(ResponseAnswer::class,Response::class);
    }

    //check if the question has multiple correct answers
    public function hasMultipleAnswers()
    {
        $count = 0;
        foreach ($this->answers as $answer)
        {
            if ($answer->is_correct)
            {
                $count++;
            }
        }
        if ($count > 1)
        {
            return true;
        }
        else
            return false;
    }
}
