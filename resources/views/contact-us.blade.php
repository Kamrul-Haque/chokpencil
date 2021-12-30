@extends('layouts.app')

@section('styles')
    <style>
        .jumbotron{
            width: 100%;
            height: 200px;
            background-color: ghostwhite;
            filter: drop-shadow(0px 2px 2px darkgray);
            background-image: linear-gradient(to left, rgba(255,255,255,0.25) 0%,rgba(255,255,255,0.25) 100%), url("{{ asset('images/undraw_contact_us_15o2.png') }}");
            background-position: 77% 100%;
            background-repeat: no-repeat;
            background-size: contain;
        }
        .hr-1{
            width: 25%;
            margin-left: 0;
            border: 2px solid dodgerblue;
        }
        .hr-2{
            width: 50%;
            margin-left: 0;
            border: 2px solid dodgerblue;
        }
    </style>
@endsection

@section('content')
    <!-- CONTENT -->
    <!-- Intro Section -->
    <section class="container-fluid px-0">
        <div class="jumbotron">
            <div class="container">
                <h1><strong>Contact Us</strong></h1>
            </div>
        </div>
    </section>
    <!-- End Intro Section -->
    <!-- Contact Section -->
    <section class="padding ptb-xs-60">
        <div class="container">

            <div class="row py-3">

                <div class="col-sm-8 mb-4">

                    <div>
                        <h2>Get in Touch</h2>
                        <hr class="hr-1">
                        <h4>Our team is always happy to assist you. Please Call us,
                            or Email us or Please fill the form below and send us to call you back. </h4>
                    </div>
                    <!-- Contact FORM -->
                    <form action="{{ route('enquiry.store') }}" class="pt-3" method="POST">
                        @csrf
                        <input type="text" id="name" name="name" class="form-control" value="" placeholder="Name" required="">
                        <br>
                        <input type="email" id="email" name="email" class="form-control" value="" placeholder="Email" required="">
                        <br>
                        <input type="text" id="phone" name="phone" class="form-control" value="" placeholder="Phone">
                        <br>
                        <textarea name="enquiry" id="enquiry" rows="3" class="form-control" required="" placeholder="Enquiry"></textarea>
                        <br>
                        <button type="submit" class="btn btn-primary btn-sm custom">Enquire</button>
                    </form>
                </div>
                <div class="col-sm-4">
                    <div class="pb-20">
                        <h2>Contact Info</h2>
                        <hr class="hr-2">
                    </div>
                    <div>


                        <ul class="list-unstyled">
                            <li>
                                <div class="d-flex">
                                    <span data-feather="phone" class="p-1 text-primary"></span>
                                    <p>
                                        01998-330487
                                    </p>
                                </div>
                            </li>
                            <li>
                                <div class="d-flex">
                                    <span data-feather="mail" class="p-1 text-primary"></span>
                                    <p>
                                        support@chokpencil.com
                                    </p>
                                </div>
                            </li>
                            <li>
                                <div class="d-flex">
                                    <span data-feather="clock" class="p-1 text-primary"></span>
                                    <p>
                                        09:00am – 11:00pm
                                    </p>
                                </div>
                            </li>
                            <li>
                                <div class="d-flex">
                                    <span data-feather="map-pin" class="p-1 text-primary"></span>
                                    House: 2, Kasim Uddin Lane, Bonomala Road<br>
                                    Dattapara, Tongi, Gazipur - 1712
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
