<?php

namespace App\Http\Controllers;

use App\Module;
use App\Course;
use Illuminate\Http\Request;

class ModuleController extends Controller
{

    public function index(Course $course)
    {
        $this->authorize('access', $course);

        return view('Module.index', compact('course'));
    }

    public function create(Course $course)
    {
        $this->authorize('modify', $course);

        return view('Module.create',compact('course'));
    }


    public function store(Request $request, Course $course)
    {
        $this->authorize('modify', $course);

        $request->validate([
           'module_name'=>'required|min:3'
        ]);

        $module = new Module;
        $module->module_name = $request->module_name;
        $module->course_id = $course->id;
        $module->save();

        return redirect()->route('module.index', $course)->with('toast_success','Successfully Created!');
    }

    public function edit(Course $course, Module $module)
    {
        $this->authorize('modify', $course);

        return view('Module.edit',compact('module','course'));
    }

    public function update(Request $request, Course $course, Module $module)
    {
        $this->authorize('modify', $course);

        $request->validate([
            'module_name'=>'required|min:3'
        ]);

        $module->module_name = $request->module_name;
        $module->save();

        return redirect()->route('module.index', $course)->with('toast_info','Successfully Updated!');
    }

    public function destroy(Course $course, Module $module)
    {
        $this->authorize('modify', $course);

        $module->delete();

        return redirect()->route('module.index', $course)->with('toast_error','Module Deleted!');
    }
}
