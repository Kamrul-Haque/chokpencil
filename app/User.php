<?php

namespace App;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    //returns an accessible http url for the asset from the storage path stored in database
    public function getProfilePhotoPathAttribute($value)
    {
        if ($value) {
            return asset($value);
        }
    }

    // checks if the user has the role passed
    public function hasRole($role)
    {
        $role = Role::where('title', $role)->first();

        if ($this->roles->contains($role))
            return true;

        return false;
    }

    public function totalMarks(Course $course)
    {
        return $this->coursesEnrolled()->find($course)->pivot->total_marks_obtained;
    }

    public function avgMarks(Course $course)
    {
        return ($course->total_marks) ? $this->totalMarks($course) / $course->total_marks * 100 : 0;
    }

    public function engagement(Course $course)
    {
        return ($course->assessments->map->questions->flatten()->count() > 0) ?
            $course->assessments->map->questions->flatten()->map->responses->flatten()->where('user_id', $this->id)->count() /
            $course->assessments->map->questions->flatten()->count() * 100 : 0;
    }

    public function roles()
    {
        return $this->belongsToMany(Role::class);
    }

    public function instructor()
    {
        return $this->hasOne(Instructor::class);
    }

    public function admin()
    {
        return $this->hasOne(Admin::class);
    }

    public function coursesOwned()
    {
        return $this->belongsToMany(Course::class, 'course_instructor', 'user_id', 'course_id');
    }

    public function coursesEnrolled()
    {
        return $this->belongsToMany(Course::class, 'course_student', 'user_id', 'course_id')->withPivot('total_marks_obtained', 'has_completed');
    }

    public function ratings()
    {
        return $this->hasMany(Rating::class, 'user_id');
    }

    public function wishlists()
    {
        return $this->hasMany(Wishlist::class, 'user_id');
    }

    public function responses()
    {
        return $this->hasMany(Response::class, 'user_id');
    }

    public function threads()
    {
        return $this->hasMany(Thread::class, 'user_id');
    }

    public function replies()
    {
        return $this->hasMany(Reply::class, 'user_id');
    }

    public function payments()
    {
        return $this->hasMany(Payment::class, 'user_id');
    }

    public function notes()
    {
        return $this->hasMany(Note::class, 'user_id');
    }
}
