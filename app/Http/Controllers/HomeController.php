<?php

namespace App\Http\Controllers;

use App\Category;
use App\Course;
use App\Institution;
use App\Role;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;

class HomeController extends Controller
{
    public function index()
    {
        $institutions = Institution::limit(7)->get();
        $courseCount = Course::all()->count();

        return view('welcome', compact( 'courseCount', 'institutions'));
    }

    public function dashboard()
    {
        if (auth()->user()->hasRole('student')) {
            if (auth()->user()->interests->count())
            {
                $courses = auth()->user()->coursesEnrolled;
                $recommendations = Course::where('level', auth()->user()->study_level)
                                        ->whereIn('category_id', auth()->user()->interests->pluck('category_id')->flatten())
                                        ->whereNotIn('id', auth()->user()->coursesEnrolled->pluck('id')->flatten())
                                        ->limit(5)->get();
                return view('Student.dashboard', compact('courses','recommendations'));
            }
            else
            {
                $categories = Category::orderBy('name')->get();
                return view('Student.interests', compact('categories'));
            }
        } elseif (auth()->user()->hasRole('instructor')) {
            $courses = auth()->user()->coursesOwned;
            return view('Instructor.dashboard', compact('courses'));
        } else {
            $institutions = Institution::all();
            $students = Role::where('title', 'student')->first()->users;
            $courses = Course::all();
            $instructors = User::has('instructor');

            return view('Admin.dashboard', compact('institutions', 'instructors', 'students', 'courses'));
        }
    }

    public function profile()
    {
        if (auth()->user()->hasRole('student'))
            return view('Student.profile');
        elseif (auth()->user()->hasRole('instructor'))
            return view('Instructor.profile');
        else
            return view('Admin.profile');
    }

    public function editProfile()
    {
        if (auth()->user()->hasRole('student')) {
            $student = auth()->user();
            return view('Student.edit', compact('student'));
        } elseif (auth()->user()->hasRole('instructor')) {
            $instructor = auth()->user()->instructor;
            return view('Instructor.edit', compact('instructor'));
        } else {
            $admin = auth()->user()->admin;
            return view('Admin.edit', compact('admin'));
        }
    }

    public function uploadPhotoForm(User $user)
    {
        return view('auth.upload-photo', compact('user'));
    }

    public function uploadPhoto(Request $request, User $user)
    {
        $request->validate([
            'image' => 'required|file|mimes:jpg,jpeg,png|max:2024'
        ]);

        $oldImage = $user->getOriginal('profile_photo_path');

        if ($request->hasFile('image')) {
            if (File::exists($oldImage))
                File::delete($oldImage);

            $path = $request->file('image')->store('UserProfilePhotos');
            $user->profile_photo_path = 'storage/' . $path;
            $user->save();
        }

        return redirect()->route('profile')->with('toast_success', 'Uploaded Successfully');
    }

    public function searchAutoComplete(Request $request)
    {
        $string = $request->get('search');

        $courses = Course::whereHas('category', function ($query) use ($string) {
            $query->where('name', 'LIKE', "%{$string}%");
        })
            ->orWhere('title', 'LIKE', "%{$string}%")
            ->orWhere('topic', 'LIKE', "%{$string}%")
            ->paginate(10);

        $output = '';

        foreach ($courses as $course) {
            if (auth()->check())
                $route = route('course.show', $course);
            else
                $route = route('guest.course.show', $course);

            $title = $course->title;

            $output .= '
                       <li class="list-group-item">
                           <a href="' . $route . '" class="list-group-item-action">' . $title . '</a>
                       </li>
                        ';
        }

        return $output;
    }

    public function search(Request $request)
    {
        $string = $request->get('search');

        $courses = Course::whereHas('category', function ($query) use ($string) {
            $query->where('name', 'LIKE', "%{$string}%");
        })
            ->orWhere('title', 'LIKE', "%{$string}%")
            ->orWhere('topic', 'LIKE', "%{$string}%")
            ->paginate();

        return view('search', compact('courses','string'));
    }

    public function changePassword(User $user)
    {
        return view('auth.passwords.change', compact('user'));
    }

    public function updatePassword(Request $request, User $user)
    {
        $request->validate([
            'old_password' => 'password:web',
            'password' => 'confirmed|min:8|different:old_password'
        ]);

        $user->password = Hash::make($request->password);
        $user->save();

        return redirect()->route('profile')->with('toast_success', 'Password Updated Successfully');
    }

    public function unreadNotifications()
    {
        $output = '';
        $count = 0;

        foreach(auth()->user()->unreadNotifications as $notification)
        {
            if($notification->type === \App\Notifications\PaymentReceived::class)
                $output .= '<span class="dropdown-item">
                                Your Payment of '. $notification->data['amount'] .' for '. $notification->data['course'] .'
                                <br>has been received. Check email for details.
                            </span>
                            <hr>';

            elseif($notification->type === \App\Notifications\PaymentConfirmed::class)
                $output .= '<span class="dropdown-item">
                                Your Payment for'. $notification->data['course'] .'<br> has been confirmed. You are now enrolled into the course.
                            </span>
                            <hr>';

            elseif($notification->type === \App\Notifications\PaymentRejected::class)
                $output .= '<span class="dropdown-item">
                                Your Payment for '. $notification->data['course'] .'<br> has been rejected. Please try again or contact support.
                            </span>
                            <hr>';

            elseif($notification->type === \App\Notifications\AccountVerified::class)
                $output .= '<span class="dropdown-item">
                                Your account has been verified. You can now teach in our platform.
                            </span>
                            <hr>';

            elseif($notification->type === \App\Notifications\Enrolled::class)
                $output .= '<span class="dropdown-item">
                                You have been enrolled into the course '. $notification->data['course'] .'.
                            </span>
                            <hr>';

            $count++;
        }

        $output .= '<span class="dropdown-item">
                            <a href="'. route('notifications') .'">see all notifications</a>
                        </span>';

        return $data = [
            'output'=>$output,
            'count'=>$count
        ];
    }

    public function readNotifications()
    {
        auth()->user()->unreadNotifications->markAsRead();
    }

    public function notifications()
    {
        return view('notifications');
    }

    public function contactUs()
    {
        return view('contact-us');
    }
}
