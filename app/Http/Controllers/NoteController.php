<?php

namespace App\Http\Controllers;

use App\Content;
use App\Note;
use Illuminate\Http\Request;

class NoteController extends Controller
{
    public function save(Request $request, $content)
    {
        $note = auth()->user()->notes()->where('content_id', $content)->first();

        if ($note === null) {
            $note = new Note();
            $note->content_id = $content;
            $note->user_id = auth()->user()->id;
            $note->text = $request->text;
        } else
            $note->text = $request->text;

        $note->save();
    }
}
