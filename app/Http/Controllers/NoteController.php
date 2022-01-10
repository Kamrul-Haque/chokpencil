<?php

namespace App\Http\Controllers;

use App\Content;
use App\Note;
use Illuminate\Http\Request;

class NoteController extends Controller
{
    public function save(Request $request, Content $content)
    {
        $request->validate([
            'text' => 'required|string'
        ]);

        $note = auth()->user()->notes()->where('content_id', $content->id)->first();

        if ($note === null) {
            $note = new Note();
            $note->content_id = $content->id;
            $note->user_id = auth()->user()->id;
        } else
            $note->text = $request->text;

        $note->save();

        return back();
    }
}
