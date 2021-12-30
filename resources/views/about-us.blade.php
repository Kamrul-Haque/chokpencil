@extends('layouts.app')

@section('styles')
    <style>
        .jumbotron{
            width: 100% !important;
            filter: drop-shadow(0px 1px 1px darkgray);
            background-image: linear-gradient( rgba(0, 0, 0, 0.5), rgba(0, 0, 0, 0.5) ), url("{{ asset('images/bg_1.jpg') }}");
            background-position: center;
            background-repeat: no-repeat;
            background-size: cover;
            padding: 100px 0;
        }
        .title{
            color: whitesmoke;
            font-size: 50px;
            font-weight: 900;
        }
        .title-2{
            color: whitesmoke;
            font-size: 35px;
            font-weight: 900;
        }
        .border-custom{
            border-left: 3px solid crimson !important;
        }
    </style>
@endsection

@section('content')
    <section class="container-fluid px-0">
        <div class="jumbotron">
            <div class="container">
                <h1 class="title">ABOUT US</h1>
            </div>
        </div>
    </section>
    <!-- Intro Section -->
    <!-- About Section -->
    <div id="about-section">
        <div class="container">
            <div class="row">
                <div class="col-sm-6 col-md-7">
                    <div class="border-custom">
                        <h2 class="pl-3"><span>Our</span> MISSION</h2>
                        <p class="font-italic pl-3"> -Saxon Academy of Learning. </p>
                    </div>
                    <div class="text-content">
                        <p> Our top priority is to prepare you for the present and future, at Saxon Academy we give students the best of education keeping in mind the career they want to choose.
                            Student can meet our student counsellors who can guide them for whatever course they want to choose and what future prospects it might have.
                            At Saxon we are committed to provide our students the very best in education which is at par with other colleges and Universities.
                            Our faculty at the academy are the best in their relative field and have hands on experience through years of experience.
                            We assure our students of proper guidance & resources for the best student experience they can have. </p>
                    </div>
                    <hr>
                    <div>
                        <img class="img-responsive" src="{{ asset('images/about-us.jpeg') }}" alt="Photo" width="100%">
                    </div>
                </div>
                <div class="col-sm-6 col-md-5">
                    <div class="card p-3 bg-danger text-light rounded-0">
                        <div class="card-body">
                            <div class="card-title">
                                <h4 class="title-2"><span>Message From The </span>CEO</h4>
                                <p class="font-italic"> -Saxon Academy of Learning </p>
                            </div>
                            <p class="card-text"> At Saxon Academy of Learning, we understand the challenges that are in store for students.
                                Our mission is to support students in meeting the challenges they face, and to help them reach their goals.
                                We provide a rich learning environment at Saxon Academy where all faculty focus on course contents and take every opportunity to help students gain knowledge and understanding of the concepts.
                                The college enhances students’ skills and teaches them to solve problems independently and to work as a team with others.
                                At Saxon Academy, we believe that it is critical to teach students to apply what they learn, which results in a balanced education – a balance of knowledge and application.
                                The faculty encourage students to use their judgment in applying their knowledge to a problem.
                                Applying what you know has to be tempered with knowing how to apply what you know, and this means using your judgment well. Good judgment is the key to success in life.
                                Saxon Academy encourages students to be diligent in their education, to persevere through difficult times, and to do their best. Warm Regards </p>
                        </div>
                    </div>
                </div>
            </div>
            <br>
        </div>
    </div>
    <!-- About Section End-->
@endsection
