<?php

namespace App\Http\Controllers;

use App\Role;
use App\Student;
use App\User;
use App\Course;
use App\Rating;
use App\Category;
use Carbon\Carbon;
use App\Instructor;
use App\Institution;
use Illuminate\Http\Request;
use App\Notifications\Enrolled;
use Illuminate\Support\Facades\File;

class CourseController extends Controller
{
    public function index()
    {
        $courses = Course::paginate();
        return view('Course.index', compact('courses'));
    }

    public function create()
    {
        $this->authorize('create', Course::class);

        $categories = Category::orderBy('name')->get();
        return view('Course.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $this->authorize('create', Course::class);

        $request->validate([
            'title' => 'required|string|min:5|unique:courses',
            'subtitle' => 'required|max:150',
            'duration_unit' => 'required|required_with:duration',
            'category' => 'required',
            'date_starting' => 'required|after:today',
            'description' => 'required|string',
            'completion_marks' => 'nullable|digits_between:1,3|gte:40|lte:100',
            'fee' => 'nullable|gt:0|lte:99999.99',
            'currency' => 'nullable|required_with:fee',
            'image' => 'nullable|file|mimes:jpeg,jpg,png|max:2024'
        ]);

        $course = new Course;
        $course->title = $request->title;
        $course->subtitle = $request->subtitle;
        $course->level = $request->level;
        $course->difficulty = $request->difficulty;
        $course->duration = $request->duration . ' ' . $request->duration_unit;
        $course->category_id = $request->category;
        $course->topic = $request->topic;
        $course->date_starting = $request->date_starting;
        $course->description = $request->description;
        if ($request->completion_marks) $course->completion_marks = $request->completion_marks;
        $course->fee = $request->fee;
        $course->currency = $request->currency;

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('CourseImage');
            $course->image_path = 'storage/' . $path;
        }

        $course->save();

        $course->discussionPanel()->create();

        $role = Role::where('title', 'instructor')->first();

        if (auth()->user()->roles->contains($role))
            $course->instructors()->syncWithoutDetaching(auth()->user()->id);

        return redirect()->route('course.show', $course)->with('toast_success', 'Successfully Created!');
    }

    public function show(Course $course)
    {
        return view('Course.show', compact('course'));
    }

    public function edit(Course $course)
    {
        $this->authorize('modify', $course);

        $duration = explode(" ", $course->duration);
        $categories = Category::orderBy('name')->get();
        return view('Course.edit', compact('course', 'categories', 'duration'));
    }

    public function update(Request $request, Course $course)
    {
        $this->authorize('modify', $course);

        $request->validate([
            'title' => 'required|string|min:5|unique:courses,title,' . $course->id,
            'subtitle' => 'required|max:150',
            'level' => 'required',
            'duration_unit' => 'required|required_with:duration',
            'category' => 'required',
            'date_starting' => 'required|after:today',
            'description' => 'required|string',
            'completion_marks' => 'nullable|digits_between:1,3|gte:40|lte:100',
            'fee' => 'nullable|gt:0|lte:99999.99',
            'currency' => 'nullable|required_with:fee',
            'image' => 'nullable|file|mimes:jpeg,jpg,png|max:2024'
        ]);

        $course->title = $request->title;
        $course->subtitle = $request->subtitle;
        $course->level = $request->level;
        $course->difficulty = $request->difficulty;
        $course->duration = $request->duration . ' ' . $request->duration_unit;
        $course->category_id = $request->category;
        $course->topic = $request->topic;
        $course->date_starting = $request->date_starting;
        $course->description = $request->description;
        $course->completion_marks = $request->completion_marks;
        $course->fee = $request->fee;
        $course->currency = $request->currency;
        $course->save();

        return redirect()->route('course.show', $course)->with('toast_info', 'Successfully Updated!');
    }

    public function destroy(Course $course)
    {
        $this->authorize('modify', $course);

        $image = $course->getOriginal('image_path');

        if (File::exists($image)) {
            File::delete($image);
        }

        $course->delete();

        return redirect()->route('course.index')->with('toast_error', 'Course Deleted!');
    }

    public function addInstructorForm(Course $course)
    {
        $this->authorize('modify', $course);

        return view('Course.add-instructor', compact('course'));
    }

    public function addInstructor(Request $request, Course $course)
    {
        $this->authorize('modify', $course);

        $request->validate([
            'uuid' => 'required|min:36|min:36'
        ]);

        $instructor = Instructor::where('uuid', (string)$request->uuid)->get()->first();

        if ($instructor) {
            if ($instructor->is_verified) {
                $course->instructors()->syncWithoutDetaching($instructor->user->id);

                return redirect()->route('course.show', $course)->with('toast_info', 'Instructor Added!');
            } else return back()->with('toast_warning', 'Instructor you are adding is not verified yet!');
        } else {
            return back()->with('toast_error', 'Incorrect Unique ID');
        }
    }

    public function leaveCourse(Course $course)
    {
        $this->authorize('leaveCourse', $course);

        $instructors = $course->instructors->count();

        if ($instructors > 1) {
            $course->instructors()->detach(auth()->user()->id);
            return redirect()->route('course.index')->with('toast_error', 'You Left the Course');
        } else {
            return redirect()->route('course.show', $course)->with('toast_warning', 'You are the only instructor. You can not leave the course!');
        }
    }

    public function enroll(Course $course)
    {
        $this->authorize('enroll', $course);

        if ($course->fee > 0) {
            return redirect()->route('payment.create', compact('course'));
        } else {
            if ($course->wishlists()->where('user_id', auth()->user()->id)->first()) {
                $course->wishlists()->where('user_id', auth()->user()->id)->first()->delete();
            }
            $course->students()->syncWithoutDetaching(auth()->user()->id);

            return redirect()->route('module.index', $course)->with('toast_success', 'Enrollment Successful!');
        }
    }

    public function unenroll(Course $course)
    {
        $this->authorize('access', $course);

        $course->students()->detach(auth()->user()->id);

        return redirect()->route('course.index', $course)->with('toast_info', 'Un-Enrolled from the Course');
    }

    public function imageUploadForm(Course $course)
    {
        $this->authorize('modify', $course);

        return view('Course.upload-image', compact('course'));
    }

    public function imageUpload(Request $request, Course $course)
    {
        $this->authorize('modify', $course);

        $request->validate([
            'image' => 'required|file|mimes:jpeg,jpg,png|max:2024'
        ]);

        $oldImage = $course->getOriginal('image_path');

        if ($request->hasFile('image')) {
            if (File::exists($oldImage)) {
                File::delete($oldImage);
            }
            $path = $request->file('image')->store('CourseImage');
            $course->image_path = 'storage/' . $path;
        }

        $course->save();

        return redirect()->route('course.show', $course)->with('toast_info', 'Successfully Uploaded!');
    }

    public function assignInstitutionForm(Course $course)
    {
        $this->authorize('assignInstitution', $course);

        $institutions = Institution::all();
        return view('Course.assign-institution', compact('institutions', 'course'));
    }

    public function assignInstitution(Request $request, Course $course)
    {
        $this->authorize('assignInstitution', $course);

        $course->institution_id = $request->institution;
        $course->save();

        return redirect()->route('course.show', $course)->with('toast_info', 'Assigned Successfully!');
    }

    public function ratingForm(Course $course)
    {
        $this->authorize('rate', $course);

        return view('Course.rating', compact('course'));
    }

    public function rating(Request $request, Course $course)
    {
        $this->authorize('rate', $course);

        $request->validate([
            'rating' => 'required',
            'review' => 'nullable|string|min:20',
        ]);

        $rating = new Rating;
        $rating->course_id = $course->id;
        $rating->user_id = auth()->user()->id;
        $rating->rating = $request->rating;
        $rating->review = $request->review;
        $rating->date = Carbon::today()->toDateString();
        $rating->save();

        return redirect()->route('course.show', $course)->with('toast_success', 'Rated Successfully!');
    }

    public function editRatingForm(Course $course, Rating $rating)
    {
        $this->authorize('rate', $course);

        return view('Course.edit-rating', compact('course', 'rating'));
    }

    public function editRating(Request $request, Course $course, Rating $rating)
    {
        $this->authorize('rate', $course);

        $request->validate([
            'rating' => 'required',
            'review' => 'nullable|string|min:20',
        ]);

        $rating->rating = $request->rating;
        $rating->review = $request->review;
        $rating->date = Carbon::today()->toDateString();
        $rating->save();

        return redirect()->route('course.show', $course)->with('toast_info', 'Rating Updated');
    }

    public function enrollStudentsForm(Course $course)
    {
        $students = Role::where('title', 'student')->first()->users;

        return view('Course.enroll-students', compact('course', 'students'));
    }

    public function enrollStudents(Request $request, Course $course)
    {
        $students = $request->input('student');

        if ($students) {
            foreach ($students as $key => $value) {
                $student = User::find($students[$key]);

                $course->students()->sync($student, false);

                $student->notify(new Enrolled($course));
            }
        }

        return back()->with('toast_success', 'Enrolled Successfully');
    }

    public function studentsReport(Course $course)
    {
        $students = $course->students()->paginate();
        return view('Course.students-report', compact('course','students'));
    }

    public function studentAssignments(Course $course, User $student)
    {
        $responses = $course->assessments->map->questions->flatten()->map->responses->flatten()->where('user_id', $student->id);
        $questions = $course->assessments->map->questions;
        return view('Course.student-assignments', compact('responses','course','student','questions'));
    }
}
