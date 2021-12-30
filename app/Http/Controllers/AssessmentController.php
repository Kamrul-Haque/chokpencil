<?php

namespace App\Http\Controllers;

use App\Assessment;
use App\Course;
use App\Module;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class AssessmentController extends Controller
{
    public function create(Course $course, Module $module)
    {
        $this->authorize('modify', $course);

        return view('Assessment.create', compact('module','course'));
    }

    public function store(Request $request, Course $course, Module $module)
    {
        $this->authorize('modify', $course);

        $request->validate([
            'title'=>'required|string|min:5',
            'deadline'=>'required|after:today',
            'attachment'=>'nullable|file',
        ]);

        $assessment = new Assessment;
        $assessment->module_id = $module->id;
        $assessment->title = $request->title;
        $assessment->description = $request->description;
        $assessment->deadline = $request->deadline;
        $assessment->total_marks = 0;
        $assessment->is_peer_graded = $request->has('peer');

        if ($request->hasFile('attachment'))
        {
            $path = $request->file('attachment')->storeAs($course->title, $request->file('attachment')->getClientOriginalName());
            $assessment->attachment_path = 'storage/'.$path;
        }
        $assessment->save();

        return redirect()->route('module.index', $course)->with('toast_success','Assessment Created Successfully!');
    }


    public function show(Course $course, Module $module, Assessment $assessment)
    {
        $this->authorize('access', $course);
        $this->authorize('view', $assessment);

        return view('Assessment.show', compact('assessment', 'module','course'));
    }

    public function edit(Course $course, Module $module, Assessment $assessment)
    {
        $this->authorize('modify', $course);

        return view('Assessment.edit', compact('module','assessment','course'));
    }

    public function update(Request $request, Course $course, Module $module, Assessment $assessment)
    {
        $this->authorize('modify', $course);

        $request->validate([
            'title'=>'required|string|min:5',
            'deadline'=>'nullable|after:today',
            'attachment'=>'nullable|file',
        ]);

        $assessment->module_id = $module->id;
        $assessment->title = $request->title;
        $assessment->description = $request->description;
        $assessment->deadline = $request->deadline ?? $assessment->getOriginal('deadline');
        $assessment->is_peer_graded = $request->has('peer');
        $oldFile = $assessment->getOriginal('attachment_path');

        if ($request->hasFile('attachment'))
        {
            if (File::exists($oldFile))
            {
                File::delete($oldFile);
            }
            $path = $request->file('attachment')->storeAs($course->title, $request->file('attachment')->getClientOriginalName());
            $assessment->attachment_path = 'storage/'.$path;
        }
        $assessment->save();

        return redirect()->route('module.index', $course)->with('toast_info','Assessment Updated');
    }

    public function destroy(Course $course, Module $module, Assessment $assessment)
    {
        $this->authorize('modify', $course);

        $oldFile = $assessment->getOriginal('attachment_path');

        if (File::exists($oldFile))
        {
            File::delete($oldFile);
        }

        $assessment->delete();

        return redirect()->route('module.index', $course)->with('toast_error','Assessment Deleted');
    }

    public function publish(Course $course, Module $module, Assessment $assessment)
    {
        $this->authorize('modify', $course);

        $assessment->is_published = true;
        $assessment->save();

        return redirect()->route('module.index', $course)->with('toast_info','Assessment Published');
    }
}
