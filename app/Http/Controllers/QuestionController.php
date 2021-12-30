<?php

namespace App\Http\Controllers;

use App\Answer;
use App\Assessment;
use App\Course;
use App\Module;
use App\Question;
use Illuminate\Http\Request;

class QuestionController extends Controller
{
    public function create(Course $course, Module $module, Assessment $assessment)
    {
        $this->authorize('modify', $course);

        return view('Question.create', compact('module','assessment','course'));
    }

    public function store(Course $course, Module $module, Assessment $assessment, Request $request)
    {
        $this->authorize('modify', $course);

        $request->validate([
            'question'=>'required|string|min:5',
            'type'=>'required|string',
            'option.*'=>'nullable|required_if:type,MCQ',
            'answer'=>'nullable|required_with:review,on',
            'marks'=>'required|numeric|between:0,100',
        ],
            [
                'answer.required_if'=>'The answer field is required when automatically graded is selected'
            ]
        );

        $question = new Question;
        $question->assessment_id = $assessment->id;
        $question->question = $request->question;
        $question->type = $request->type;
        $question->marks = $request->marks;

        if ($request->type == 'MCQ')
            $question->needs_review =  false;
        /*else
            $question->needs_review = !($request->has('review'));*/
        if ($question->save())
        {
            $assessment->total_marks += $request->marks;
            $assessment->save();
            $course->total_marks += $request->marks;
            $course->save();

            if ($request->type == 'MCQ')
            {
                foreach ($request->input('option') as $key=>$option)
                {
                    $answer = new Answer;
                    $answer->question_id = $question->id;
                    $answer->answer = $option;
                    $answer->is_correct = $request->has('correct'.$key);
                    $answer->save();
                }
            }
            else if($request->type == 'Short Question' && $request->has('review'))
            {
                $answer = new Answer;
                $answer->question_id = $question->id;
                $answer->answer = $request->answer;
                $answer->is_correct = true;
                $answer->save();
            }
        }

        return redirect()->route('assessment.show', ['course'=>$course,'module'=>$module,'assessment'=>$assessment])->with('toast_success','Created Successfully!');
    }

    public function edit(Course $course, Module $module, Assessment $assessment, Question $question)
    {
        $this->authorize('modify', $course);

        return view('Question.edit', compact('course','module','assessment','question'));
    }

    public function update(Course $course, Module $module, Assessment $assessment, Question $question, Request $request)
    {
        $this->authorize('modify', $course);

        $request->validate([
            'question'=>'required|string|min:5',
            'type'=>'required|string',
            'option.*'=>'nullable|required_if:type,MCQ',
            'answer'=>'nullable|required_with:review,on',
            'marks'=>'required|numeric|between:0,100',
        ],
            [
                'answer.required_if'=>'The answer field is required when automatically graded is selected'
            ]
        );

        $assessment->total_marks -= $question->marks;
        $assessment->save();
        $course->total_marks -= $question->marks;
        $course->save();

        $question->assessment_id = $assessment->id;
        $question->question = $request->question;
        $question->type = $request->type;
        $question->marks = $request->marks;
        if ($request->type == 'MCQ')
            $question->needs_review =  false;
        /*else
            $question->needs_review = !($request->has('review'));*/
        if ($question->save())
        {
            foreach ($question->answers as $answer)
            {
                $answer->delete();
            }

            $assessment->total_marks += $request->marks;
            $assessment->save();
            $course->total_marks += $request->marks;
            $course->save();

            if ($request->type == 'MCQ')
            {
                foreach ($request->input('option') as $key=>$option)
                {
                    $answer = new Answer;
                    $answer->question_id = $question->id;
                    $answer->answer = $option;
                    $answer->is_correct = $request->has('correct'.$key);
                    $answer->save();
                }
            }
            else if($request->type == 'Short Question' && $request->has('review'))
            {
                $answer = new Answer;
                $answer->question_id = $question->id;
                $answer->answer = $request->answer;
                $answer->is_correct = true;
                $answer->save();
            }
        }

        return redirect()->route('assessment.show', ['course'=>$course,'module'=>$module,'assessment'=>$assessment])->with('toast_info','Successfully Updated');
    }

    public function destroy(Course $course, Module $module, Assessment $assessment, Question $question)
    {
        $this->authorize('modify', $course);

        if ($question->delete())
        {
            $assessment->total_marks -= $question->getOriginal('marks');
            $assessment->save();
            $course->total_marks -= $question->getOriginal('marks');
            $course->save();
        }

        return redirect()->route('assessment.show', ['course'=>$course,'module'=>$module,'assessment'=>$assessment])->with('toast_error','Record Deleted');
    }
}
