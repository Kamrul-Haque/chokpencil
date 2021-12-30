<?php

namespace App\Http\Controllers;

use App\Announcement;
use App\Course;
use Illuminate\Http\Request;

class AnnouncementController extends Controller
{
    public function create(Course $course)
    {
        $this->authorize('modify', $course);

        return view('Announcement.create', compact('course'));
    }

    public function store(Request $request, Course $course)
    {
        $this->authorize('modify', $course);

        $request->validate([
            'message'=>'required|string|min:10',
        ]);

        $announcement = new Announcement();
        $announcement->course_id = $course->id;
        $announcement->message = $request->message;
        $announcement->save();

        return redirect()->route('module.index', $course)->with('toast_success','Created Successfully');
    }

    public function edit(Course $course, Announcement $announcement)
    {
        $this->authorize('modify', $course);

        return view('Announcement.edit', compact('announcement','course'));
    }

    public function update(Request $request, Course $course, Announcement $announcement)
    {
        $this->authorize('modify', $course);

        $request->validate([
           'message'=>'required|string|min:10',
        ]);

        $announcement->course_id = $announcement->course->id;
        $announcement->message = $request->message;
        $announcement->save();

        return redirect()->route('module.index', $course)->with('toast_info','Updated Successfully');
    }

    public function destroy(Course $course, Announcement $announcement)
    {
        $this->authorize('modify', $course);

        $announcement->delete();
        return back()->with('toast_error','Record Deleted');
    }
}
