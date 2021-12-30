@extends('layouts.app')

@section('styles')
    <style>
       .button{
           line-height: 200px;
           font-size: xx-large;
           font-weight: bolder;
           border-radius: 0;
           filter: drop-shadow(0px 5px 5px darkgray);
       }
       .green:hover{
           border-radius: 0;
           box-shadow: 5px 5px #38bf72;
       }
       .blue:hover{
           border-radius: 0;
           box-shadow: 5px 5px #348fdb;
       }
       .red:hover{
           border-radius: 0;
           box-shadow: 5px 5px #e13430;
       }
       .black:hover{
           border-radius: 0;
           box-shadow: 5px 5px #343a40;
       }
    </style>
@endsection

@section('content')
    <div class="container py-4">
        <div class="row pt-5">
            <div class="col-md-6">
                <div class="">
                    <a href="{{ route('admin.institution.index') }}" class="btn btn-block btn-success green button">{{ $institutions->count() }} Institutions</a>
                </div>
            </div>
            <div class="col-md-6">
                <div class="">
                    <a href="{{ route('course.index') }}" class="btn btn-block btn-primary button blue">{{ $courses->count() }} Courses</a>
                </div>
            </div>
        </div>
        <div class="row pt-5">
            <div class="col-md-6">
                <div class="">
                    <a href="{{ route('admin.instructor.index') }}" class="btn btn-block btn-danger red button">{{ $instructors->count() }} Instructors</a>
                </div>
            </div>
            <div class="col-md-6">
                <div class="">
                    <a href="{{ route('admin.user.index') }}" class="btn btn-block btn-dark button black">{{ $students->count() }} Students</a>
                </div>
            </div>
        </div>
    </div>
@endsection
