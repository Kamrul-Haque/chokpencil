<?php

namespace App\Http\Controllers;

use App\Course;
use App\DiscussionPanel;
use App\Reply;
use App\Thread;
use Illuminate\Http\Request;

class ReplyController extends Controller
{
    public function store(Request $request, Course $course, DiscussionPanel $discussionPanel, Thread $thread)
    {
        $request->validate([
            'message'=>'required|string|max:255'
        ]);

        $reply = new Reply();
        $reply->thread_id = $thread->id;
        $reply->message = $request->message;
        $reply->user_id = auth()->user()->id;
        $reply->save();

        return redirect()
            ->route('thread.show', ['course'=>$course, 'discussionPanel'=>$discussionPanel, 'thread'=>$thread])
            ->with('toast_success','Reply Created Successfully!');
    }

    public function update(Request $request, Course $course, DiscussionPanel $discussionPanel, Thread $thread, Reply $reply)
    {
        $this->authorize('modify',$reply);

        $request->validate([
            'message'=>'required|string|max:255'
        ]);

        $reply->message = $request->message;
        $reply->save();

        return redirect()
            ->route('thread.show', ['course'=>$course, 'discussionPanel'=>$discussionPanel, 'thread'=>$thread])
            ->with('toast_info','Reply Updated!');
    }

    public function destroy(Course $course, DiscussionPanel $discussionPanel, Thread $thread, Reply $reply)
    {
        $this->authorize('modify',$reply);

        $reply->delete();

        return redirect()
            ->route('thread.show', ['course'=>$course, 'discussionPanel'=>$discussionPanel, 'thread'=>$thread])
            ->with('toast_error','Reply Deleted');
    }

    public function markSolution(Reply $reply)
    {
        $this->authorize('modify', $reply->thread);

        $id = $reply->thread->hasSolution();

        if ($id)
        {
            $oldSolution = Reply::find($id);
            $oldSolution->is_solution = false;
            $oldSolution->save();
        }

        $reply->is_solution = true;
        $reply->save();

        return back()->with('toast_success','marked as solution!');
    }
}
