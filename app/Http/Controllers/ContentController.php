<?php

namespace App\Http\Controllers;

use App\Content;
use App\Course;
use App\Module;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class ContentController extends Controller
{
    public function create(Course $course, Module $module)
    {
        $this->authorize('modify', $course);

        return view('Content.create', compact('module','course'));
    }

    public function store(Request $request, Course $course, Module $module)
    {
        $this->authorize('modify', $course);

        $request->validate([
           'title'=>'required|string|min:5',
           'type'=>'required|string',
           'description'=>'required_if:type,Text',
           'link'=>'nullable|required_if:type,Link|url',
           'video'=>'nullable|required_if:type,Video|url',
           'file'=>'nullable|required_if:type,File|file',
        ]);

        $content = new Content;
        $content->module_id = $module->id;
        $content->title = $request->title;
        $content->type = $request->type;
        $content->description = $request->description;
        $content->web_link = $request->link;
        $content->video_link = $request->video;
        $content->is_protected = $request->has('protected');

        if ($request->hasFile('file'))
        {
            $path = $request->file('file')->storeAs($course->title, $request->file('file')->getClientOriginalName());
            $content->file_path = 'storage/'.$path;
        }
        $content->save();

        return redirect()->route('module.index', $course)->with('toast_success','Content Created Successfully!');
    }

    public function show(Course $course, Module $module, Content $content)
    {
        $this->authorize('access', $course);

        return view('Content.show', compact('content','module','course'));
    }

    public function edit(Course $course, Module $module, Content $content)
    {
        $this->authorize('modify', $course);

        return view('Content.edit', compact('module','content','course'));
    }

    public function update(Request $request, Course $course, Module $module, Content $content)
    {
        $this->authorize('modify', $course);

        $request->validate([
            'title'=>'required|string|min:5',
            'type'=>'required|string',
            'description'=>'required_if:type,Text',
            'link'=>'nullable|required_if:type,Link|url',
            'video'=>'nullable|required_if:type,Video|url',
            'file'=>'nullable|required_if:type,File|file',
        ]);

        $content->module_id = $module->id;
        $content->title = $request->title;
        $content->type = $request->type;
        $content->description = $request->description;
        $content->web_link = $request->link;
        $content->video_link = $request->video;
        $content->is_protected = $request->has('protected');
        $oldFile = $content->getOriginal('file_path');

        if ($request->hasFile('file'))
        {
            if (File::exists($oldFile))
            {
                File::delete($oldFile);
            }
            $path = $request->file('file')->storeAs($course->title, $request->file('file')->getClientOriginalName());
            $content->file_path = 'storage/'.$path;
        }
        $content->save();

        return redirect()->route('module.index', $course)->with('toast_info','Content Updated');
    }

    public function destroy(Course $course, Module $module, Content $content)
    {
        $this->authorize('modify', $course);

        $oldFile = $content->getOriginal('file_path');

        if (File::exists($oldFile))
        {
            File::delete($oldFile);
        }

        $content->delete();

        return redirect()->route('module.index', $course)->with('toast_error','Content Deleted');
    }
}
