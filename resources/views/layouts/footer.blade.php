<div class="container-fluid bg-primary footer-div">
    <div  class="bg-primary footer-container text-white pt-4">
        <div class="row pt-4">
            <div class="col-md-4 col-sm-12 pb-4">
                <div class="pb-4">
                    <h2>ChokPencil</h2>
                </div>
                <div>
                    <p>
                        is a leading e-learning platform in Bangladesh aims to deliver
                        <br>
                        not only quality education but also looks forward to improve
                        <br>
                        the quality of distant learning in general.
                    </p>
                    <br><br>
                    <div>
                        <a href="#" class="text-white pr-3"
                        ><i class="fa fa-facebook-f"></i
                            ></a>
                        <a href="#" class="text-white pr-3"
                        ><i class="fa fa-twitter"></i
                            ></a>
                        <a href="#" class="text-white pr-3"
                        ><i class="fa fa-linkedin"></i
                            ></a>
                        <a href="#" class="text-white pr-3"
                        ><i class="fa fa-instagram"></i
                            ></a>
                        <a href="#" class="text-white pr-3"
                        ><i class="fa fa-youtube"></i
                            ></a>
                    </div>
                </div>
            </div>
            <div class="col-md-3 col-sm-12 pb-4">
                <h4>Contact Us</h4>
                <div>
                    <span href="#" class="text-white pr-2">
                        <i class="fa fa-phone pr-2"></i>01998-330487
                    </span>
                    <br/>
                    <span href="#" class="pr-2 text-white">
                        <i class="fa fa-envelope pr-2"></i>support@chokpencil.com
                    </span>
                    <br>
                    <span href="#" class="pr-2 text-white">
                        <i class="fa fa-clock-o pr-2"></i>9:00am to 11:00pm
                    </span>
                    <p>
                        <i class="fa fa-map-marker pr-2"></i>
                        House: 2, Kasim Uddin Lane, Bonomala Road<br>
                        <span class="pl-4">Dattapara, Tongi, Gazipur - 1712</span>
                    </p>
                </div>
            </div>
            <div class="col-md-2 col-sm-12 pb-4">
                <h4>Featured Courses</h4>
                <div>
                    @isset($data['featuredCourses'])
                        @foreach($data['featuredCourses'] as $course)
                        <a href="{{ route('guest.course.show', $course) }}" class="text-decoration-none text-white">{{ $course->title }}</a>
                        @continue($loop->last)<br/>
                        @endforeach
                    @else
                        <a href="{{ route('guest.course.index') }}" class="text-decoration-none text-white">All Courses</a>
                    @endisset
                </div>
            </div>
            @isset($data['topCategories'])
            <div class="col-md-3 col-sm-12 pb-4">
                <h4>Top Categories</h4>
                <div>
                    @foreach($data['topCategories'] as $category)
                        <a href="{{ route('category.show', $category) }}" class="text-decoration-none text-white">{{ $category->name }}</a>
                        @continue($loop->last)<br/>
                    @endforeach
                </div>
            </div>
            @endisset
        </div>
    </div>
</div>
<hr class="p-0 m-0">
@include('layouts.copyright')
