<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;

class Course extends Model
{
    use SoftDeletes;

    protected $guarded = [];

    //returns an accessible http url for the asset from the storage path stored in database
    public function getImagePathAttribute($value)
    {
        if ($value) {
            return asset($value);
        }
    }

    //returns the date in custom format
    public function getDateStartingAttribute($value)
    {
        $carbon = new Carbon($value);
        return $carbon->format('d/m/Y');
    }

    //checks if the course belongs to the given instructor
    public function hasInstructor($id)
    {
        if (Auth::guard('instructor')->check()) {
            return $this->instructors->contains($id);
        } else
            return false;
    }

    //checks if the given student is enrolled in the course
    public function hasStudent($id)
    {
        if (Auth::guard('student')->check()) {
            return $this->students->contains($id);
        }
        return false;
    }

    public function rated()
    {
        return $this->ratings()->where('user_id', auth()->user()->id)->first();
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function instructors()
    {
        return $this->belongsToMany(User::class, 'course_instructor', 'course_id', 'user_id');
    }

    public function students()
    {
        return $this->belongsToMany(User::class, 'course_student', 'course_id', 'user_id')->withPivot('total_marks_obtained', 'has_completed');
    }

    public function modules()
    {
        return $this->hasMany(Module::class);
    }

    public function contents()
    {
        return $this->hasManyThrough(Content::class, Module::class);
    }

    public function assessments()
    {
        return $this->hasManyThrough(Assessment::class, Module::class);
    }

    public function institution()
    {
        return $this->belongsTo(Institution::class);
    }

    public function ratings()
    {
        return $this->hasMany(Rating::class);
    }

    public function wishlists()
    {
        return $this->hasMany(Wishlist::class);
    }

    public function discussionPanel()
    {
        return $this->hasOne(DiscussionPanel::class);
    }

    public function announcements()
    {
        return $this->hasMany(Announcement::class);
    }

    public function paymentInfos()
    {
        return $this->hasMany(PaymentInfo::class);
    }

    public function payments()
    {
        return $this->hasMany(Payment::class);
    }

    public function recievedPayments()
    {
        return $this->hasMany(ReceivedPayment::class);
    }
}
