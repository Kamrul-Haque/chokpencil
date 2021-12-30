@extends('layouts.app')

@section('styles')
    <style>
        .jumbotron{
            width: 100%;
            height: 200px;
            background-color: ghostwhite;
            filter: drop-shadow(0px 2px 2px darkgray);
            background-image: linear-gradient(to left, rgba(255,255,255,0.25) 0%,rgba(255,255,255,0.25) 100%), url("{{ asset('images/undraw_Search_re_x5gq.png') }}");
            background-position: 77% 100%;
            background-repeat: no-repeat;
            background-size: contain;
        }
        .hr{
            width: 100%;
        }
        .disabled{
            filter: invert(75%);
        }
        .btn-block{
            border-radius: 0;
        }
        .btn-block:hover{
            filter: drop-shadow(0 3px 3px darkgray);
        }
        .logo{
            display: block;
            max-height: 50px;
            max-width: 125px;
            left: 0;
        }
        .course-image{
            width: 100%;
            max-height: 150px;
        }
        a.course-title{
            font-family: Helvetica;
            color: crimson;
        }
        a.course-title:hover,a.course-title:focus{
            text-decoration: none;
            color: darkred;
        }
        .wishlist-button{
            outline: none;
            background: transparent;
            border: none;
            padding-left: 0;
        }
        .wishlist-button:hover{
            text-decoration: underline;
        }
        .bg-custom{
            background-color: floralwhite;
        }
        .card-custom{
            top: -20%;
            left: 15%;
            width: 175px;
            box-shadow: 0 1px 2px 0 darkgrey;
        }
    </style>
@endsection

@section('content')
    @include('Course.index')
@endsection
