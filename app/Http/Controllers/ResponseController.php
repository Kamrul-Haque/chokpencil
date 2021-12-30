<?php

namespace App\Http\Controllers;

use App\Assessment;
use App\Course;
use App\Module;
use App\Question;
use App\Response;
use App\ResponseAnswer;
use Illuminate\Http\Request;

class ResponseController extends Controller
{
    public function index(Course $course, Module $module, Assessment $assessment, Question $question)
    {
        $this->authorize('modify', $course);

        $responses = Response::where('question_id',$question->id)->paginate(10);

        return view('Response.index',compact('responses','module','assessment','question','course'));
    }

    public function store(Course $course, Module $module, Assessment $assessment, Question $question, Request $request)
    {
        $this->authorize('access', $course);

        $request->validate([
            'answer'=>'sometimes|required|string',
            'options'=>'sometimes|required',
            'link'=>'sometimes|required|url',
            'attachment'=>'sometimes|required|file',
        ]);

        $response = new Response;
        $response->question_id = $question->id;
        $response->user_id = auth()->user()->id;

        $responseAnswer = new ResponseAnswer;
        $correct_answers = $question->answers()->where('is_correct',true)->get();

        if ($question->hasMultipleAnswers())
        {
            $count = 0;
            foreach ($request->options as $option)
            {
                foreach ($correct_answers as $answer)
                {
                    if ($option == $answer->answer)
                        $count++;
                }
            }
            if ($count == $correct_answers->count())
            {
                $response->is_correct = true;
                $response->obtained_marks = $question->marks;
            }
            else
                $response->obtained_marks = 0;

            $response->save();

            $dataset = [];
            foreach ($request->options as $option)
            {
                $dataset[] = [
                    'response_id'=>$response->id,
                    'answer'=>$option,
                ];
            }
            ResponseAnswer::insert($dataset);
        }
        elseif (!($question->needs_review))
        {
            if ($request->answer == $correct_answers->first()->answer)
            {
                $response->is_correct = true;
                $response->obtained_marks = $question->marks;
            }
            else
                $response->obtained_marks = 0;

            $response->save();

            $responseAnswer->answer = $request->answer;
            $responseAnswer->response_id = $response->id;
            $responseAnswer->save();
        }
        else
        {
            if ($request->has('link'))
            {
                $response->save();

                $responseAnswer->answer = $request->link;
                $responseAnswer->response_id = $response->id;
                $responseAnswer->save();
            }
            else if ($request->has('attachment'))
            {
                if ($request->hasFile('attachment'))
                {
                    $response->save();

                    $path = $request->file('attachment')->storeAs($module->course->title, $request->file('attachment')->getClientOriginalName());
                    $responseAnswer->attachment_path = 'storage/'.$path;

                    $responseAnswer->response_id = $response->id;
                    $responseAnswer->save();
                }
            }
            else
            {
                $response->save();

                $responseAnswer->answer = $request->answer;
                $responseAnswer->response_id = $response->id;
                $responseAnswer->save();
            }
        }

        $course->students()->updateExistingPivot($response->student,['total_marks_obtained'=>$course->students()->find($response->student)->total_marks_obtained += $request->marks]);

        return redirect()->route('assessment.show',['course'=>$course,'module'=>$module,'assessment'=>$assessment])->with('toast_success','Submitted Successfully!');
    }

    public function grade(Course $course, Module $module, Assessment $assessment, Question $question, Response $response, Request $request)
    {
        $this->authorize('modify', $course);

        if (!$response->obtained_marks)
        {
            $request->validate([
                'marks'=>'required|numeric|between:0,'.$question->marks
            ]);

            $response = Response::find($response->id);
            $response->obtained_marks = $request->marks;
            if ($response->save())
            {
                $course->students()->updateExistingPivot($response->student,['total_marks_obtained'=>$course->students()->find($response->student)->total_marks_obtained += $request->marks]);
            }

            return redirect()->route('response.index',['course'=>$course,'module'=>$module,'assessment'=>$assessment,'question'=>$question])->with('toast_success','Graded Successfully!');
        }
        else
            return back()->with('toast_warning','Already Graded');
    }
}
