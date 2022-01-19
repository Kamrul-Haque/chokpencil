<?php

namespace App\Http\Controllers;

use App\Certificate;
use App\Course;
use Barryvdh\DomPDF\Facade as PDF;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CertificateController extends Controller
{
    public function create(Course $course)
    {
        return view('Certificate.create', compact('course'));
    }

    public function store(Course $course, Request $request)
    {
        $students = $course->students;

        foreach ($students as $student)
        {
            if ($student->avgMarks($course)>=$course->completion_marks)
            {
                Certificate::create([
                    'course_id'=>$course->id,
                    'user_id'=>$student->id
                ]);
            }
        }

        return redirect()->route('module.index', $course)->with('toast_success','Issued Successfully');
    }

    public function show(Course $course, Certificate $certificate)
    {
        $pdf = PDF::loadView('Certificate.show', compact('certificate','course'));
        return $pdf->download('Certificate.pdf');
    }
}
