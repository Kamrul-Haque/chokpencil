<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <!-- Bootstrap 4.1 -->
    <link
        rel="stylesheet"
        href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css"
        integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO"
        crossorigin="anonymous"
    />

    <!-- font awesome -->
    <link
        rel="stylesheet"
        href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css"
        integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p"
        crossorigin="anonymous"
    />
    <!-- slick slider -->
    <link
        rel="stylesheet"
        type="text/css"
        href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.5.9/slick.min.css"
    />
    <link
        rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.5.9/slick-theme.min.css"
    />
    <!-- stylesheet -->

    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('css/form.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/font-awesome.css') }}">

    <!-- fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">
    <title>{{ config('app.name') }}</title>

    <script
    src="https://code.jquery.com/jquery-3.3.1.slim.min.js"
    integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo"
    crossorigin="anonymous"
></script>
</head>
<body>
<!-- header section start from here -->
@include('layouts.navbar')

<!-- Main section Start from here -->
<main>
    <!-- hero section  -->
    <section class="mt-5 hero-container">
        <div class="row">
            <div class="col hero-section">
                <h6 class="text-primary">WORLD CLASS COURSE PLATFORM</h6>
                <h2>
                    Access to
                    <span class="text-primary mark-text mark-text-first">{{ $courseCount }}+</span>
                    courses from the Bangladesh’s leading educational institutions,
                    <span class="mark-text mark-text-second"></span> delivered by
                    most experienced instructors.
                </h2>

                <div>
                    <form action="{{ route('search') }}" class="position-relative w-75" method="GET">
                        @csrf
                        <div class="d-flex position-relative">
                            <input class="form-control search-box" type="search" id="search" name="search" placeholder="Search Courses..." aria-label="Search" autocomplete="off">
                            <button class="btn btn-outline-dark btn-search btn-sm" type="submit">Search</button>
                        </div>
                        <div class="position-absolute w-100">
                            <ul class="list-group" id="suggestions">

                            </ul>
                        </div>
                    </form>
                </div>
            </div>

            <div class="col">
                <div class="row img-container">
                    <div class="col">
                        <img
                            class="rounded img-sizing-1"
                            src="{{ asset('images/img1.jpg') }}"
                            alt=""
                        />
                    </div>
                    <div class="col">
                        <div>
                            <img
                                class="rounded mb-4 img-sizing-2"
                                src="{{ asset('images/img3.jpg') }}"
                                alt=""
                            />
                        </div>
                        <div>
                            <img
                                class="rounded img-sizing-3"
                                src="{{ asset('images/img2.jpg') }}"
                                alt=""
                            />
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- OutLine Section -->
    <section class="mt-5 bg-primary text-white">
        <div class="outline-container">
            <div >
                <div>
                    <i class="fas fa-user-graduate"></i>
                </div>
               <div>
                    <h5>Learn From Experts</h5>
               </div>

            </div>
            <div >
                <div>
                    <i class="fas fa-laptop-code"></i>
                </div>
               <div>
                    <h5>Find Quality Contents</h5>
               </div>

            </div>
            <div >

                <div>
                    <i class="fas fa-cogs"></i>

                </div>
                <div>
                     <h5>Sharpen Your Skills</h5>
                </div>
            </div>
            <div >

                <div>
                    <i class="fas fa-warehouse-alt"></i>
                </div>
                <div>
                     <h5>Be Industry Ready</h5>
                </div>
            </div>
            <div  >
                <div>
                     <i class="fas fa-globe"></i>
                </div>
               <div>
                    <h5>Compete with World</h5>
               </div>

            </div>
        </div>
    </section>

    <!-- New Courses Section -->
    @isset ($data['featuredCourses'])
    <section class="course-container pt-5">
        <h2 class="text-center pt-2">
            Featured <span class="mark-text mark-text-third">Courses</span>
        </h2>

        <!-- slider -->
        <div class="main pt-5 slider-container">
            <div class="slider slider-nav">
                @foreach($data['featuredCourses'] as $featuredCourse)
                <div style="background-image:linear-gradient(rgba(0, 0, 0, 0.60), rgba(0, 0, 0, 0.60)),
                            url('{{($featuredCourse->image_path) ? $featuredCourse->image_path : asset('images/No_Image_Available.jpg')}}');
                            background-size: cover; background-repeat: no-repeat;height:251px ; position:relative">
                    <div class="overlay">
                        <p class="pt-5">{{ $featuredCourse->title }}</p>
                        <a class="btn bg-danger slider-btn" href="{{ route('course.show', $featuredCourse) }}">Learn More</a>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </section>
    @endisset

    <!-- Top Categories Sdection -->
    @isset($data['topCategories'])
    <section class="categories">
        <h2 class="text-center pt-5">
            Top <span class="mark-text mark-text-fourth">Categories</span>
        </h2>
        <div class="pt-5 grid-container">
            @foreach($data['topCategories'] as $category)
                <div class="card-cg"
                     style="background-image:linear-gradient(rgba(0, 0, 0, 0.3),
                            rgba(0, 0, 0, 0.3)), url('{{($category->image) ? $category->image : asset('images/No_Image_Available.jpg')}}');
                            background-size: cover; background-repeat: no-repeat; height:250px" >
                    <a href="{{ route('category.show', $category) }}">{{ $category->name }}</a>
                </div>
            @endforeach
        </div>
    </section>
    @endisset
    <!-- Partner Logo Section -->
    @if($institutions->count())
    <section class="categories mt-5 mb-2">
        <h2 class="text-center pb-3">
            Partner <span class="mark-text mark-text-fourth">Institutions</span>
        </h2>
        <ul class="list-group-horizontal-md d-md-flex justify-content-center list-unstyled">
            @foreach($institutions as $institution)
                <li class="list-inline-item mx-3 pb-3">
                    <img src="{{ $institution->logo_path ?? asset('images/Icons/university.png')}}" alt="" style="max-height: 70px">
                </li>
            @endforeach
        </ul>
    </section>
    @endif

    <!-- footer section -->
    @include('layouts.footer')
</main>

<!-- <div class="online-cta bg-dark">Online</div> -->
<!-- jquery -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
<!-- slick script -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.5.9/slick.min.js"></script>
<!-- Custom js file -->
<script src="{{ asset('js/script.js') }}"></script>
<!-- bootstrap script  -->
<script
    src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"
    integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49"
    crossorigin="anonymous"
></script>
<script
    src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"
    integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy"
    crossorigin="anonymous"
></script>
</body>
</html>
<script type="text/javascript">
    $(document).ready(function () {
        function result(query = '') {
            if (query.length>2)
            {
                var route = "{{ route('search.auto.complete') }}";
                var search = query;

                $.ajax({
                    url: route,
                    method: "GET",
                    data: {search:search},
                    success: function (response){
                        console.log(response);
                        $('#suggestions').html(response);
                    }
                });
            }
            else $('#suggestions').html('');
        }
        $(document).on('keyup', '#search', function(){
            var query = $(this).val();
            result(query);
        });
    });
</script>
