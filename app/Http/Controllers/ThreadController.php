<?php

namespace App\Http\Controllers;

use App\Course;
use App\DiscussionPanel;
use App\Thread;
use Illuminate\Http\Request;

class ThreadController extends Controller
{
    public function index(Course $course, DiscussionPanel $discussionPanel)
    {
        $this->authorize('access', $course);

        $threads = $discussionPanel->threads()->latest()->paginate(3);
        return view('Thread.index', compact('threads','course', 'discussionPanel'));
    }

    public function create(Course $course, DiscussionPanel $discussionPanel)
    {
        $this->authorize('access', $course);

        return view('Thread.create', compact('course','discussionPanel'));
    }

    public function store(Request $request, Course $course, DiscussionPanel $discussionPanel)
    {
        $this->authorize('access', $course);

        $request->validate([
            'select'=>'required',
            'subject'=>'required|string|max:30',
            'message'=>'required|string'
        ]);

        $thread = new Thread();
        $thread->discussion_panel_id = $discussionPanel->id;
        if ($request->select) $thread->content_id = $request->select;
        $thread->subject = $request->subject;
        $thread->body = $request->message;
        $thread->user_id = auth()->user()->id;
        $thread->save();

        return redirect()
            ->route('thread.show', ['course'=>$course, 'discussionPanel'=>$discussionPanel, 'thread'=>$thread])
            ->with('toast_success','Post Created Successfully!');
    }

    public function show(Course $course, DiscussionPanel $discussionPanel, Thread $thread)
    {
        $this->authorize('access', $course);

        return view('Thread.show', compact('course','discussionPanel','thread'));
    }

    public function edit(Course $course, DiscussionPanel $discussionPanel, Thread $thread)
    {
        $this->authorize('modify', $thread);

        return view('Thread.edit',compact('course','discussionPanel','thread'));
    }

    public function update(Request $request, Course $course, DiscussionPanel $discussionPanel, Thread $thread)
    {
        $this->authorize('modify', $thread);

        $request->validate([
            'subject'=>'required|string|max:30',
            'message'=>'required|string'
        ]);

        $thread->subject = $request->subject;
        $thread->body = $request->message;
        $thread->save();

        return redirect()
            ->route('thread.show', ['course'=>$course, 'discussionPanel'=>$discussionPanel, 'thread'=>$thread])
            ->with('toast_info','Post Updated Successfully');
    }

    public function destroy(Course $course, DiscussionPanel $discussionPanel, Thread $thread)
    {
        $this->authorize('modify', $thread);

        $thread->delete();

        return redirect()
            ->route('thread.index', ['course'=>$course, 'discussionPanel'=>$discussionPanel])
            ->with('toast_error','Post Deleted');
    }

    public function filter(Course $course, DiscussionPanel $discussionPanel, $content)
    {
        if($content)
        {
            $threads = Thread::where('content_id', $content)->paginate(10);
        }
        else
        {
            $threads = Thread::where('content_id', null)->paginate(10);
        }
        return view('Thread.index', compact('threads','course', 'discussionPanel'));
    }
}
