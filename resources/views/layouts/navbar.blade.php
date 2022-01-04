<link rel="stylesheet" href="{{ asset('css/navbar.css') }}">
<header class="sticky-top">
    <nav class="py-3 bg-primary">
        <div class="container-fluid nav-container">
            <div class="d-flex justify-content-between">
                <div class="flex-column pl-3">
                    <a href="#" class="text-white pr-2">
                        <i class="fa fa-phone pr-2"></i> 01998-330487
                    </a>
                    <a href="#" class="text-white email-block">
                        <i class="fa fa-envelope pl-3 pr-2 border-left"></i> support@chokpencil.com
                    </a>
                </div>

                <div class="flex-column">
                    @guest
                    <div class="pr-3">
                        <a href="{{ route('login') }}" class="text-white font-weight-bolder pr-2">Login</a>
                        <a href="{{ route('register') }}" class="text-white font-weight-bolder pl-3 pr-2 border-left">Register</a>
                    </div>
                    @else
                    <div class="pr-3">
                        <a href="{{ route('dashboard') }}" class="text-white font-weight-bolder">Home</a>
                    </div>
                    @endguest
                </div>
            </div>
        </div>
    </nav>

    <nav
        class="
					navbar navbar-expand-lg
					shadow
					navbar-light
					bg-light
					d-flex
					justify-content-between
				"
    >
        <div class="container-fluid nav-container">
            <a class="navbar-brand" href="{{ config('app.url') }}">
                <img src="{{ asset('images/logo.png') }}" alt="{{ config('app.name', 'Laravel') }}" class="py-2" height="50px" width="auto">
            </a>
            <button
                class="navbar-toggler"
                type="button"
                data-toggle="collapse"
                data-target="#navbarSupportedContent"
                aria-controls="navbarSupportedContent"
                aria-expanded="false"
                aria-label="Toggle navigation"
            >
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav ml-auto">
                    {{--@isset($data['featuredCourses'])
                        <li class="nav-item dropdown mr-2">
                            <a class="nav-link dropdown-toggle mr-2 design" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Featured Courses</a>
                            <div>
                                <div class="dropdown-menu dropdown-menu-left border-0" aria-labelledby="notificationButton">
                                    @foreach($data['featuredCourses'] as $course)
                                        <a href="{{ route('course.show', $course) }}" class="dropdown-item">{{ $course->title }}</a>
                                        @continue($loop->last) <div class="dropdown-divider"></div>
                                    @endforeach
                                </div>
                            </div>
                        </li>
                    @endisset
                    @isset($data['topCategories'])
                        <li class="nav-item dropdown mr-2">
                            <a class="nav-link dropdown-toggle mr-2 design" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Top Categories</a>
                            <div>
                                <div class="dropdown-menu dropdown-menu-left border-0" aria-labelledby="notificationButton">
                                    @foreach($data['topCategories'] as $category)
                                        <a href="{{ route('category.show', $category) }}" class="dropdown-item">{{ $category->name }}</a>
                                        @continue($loop->last) <div class="dropdown-divider"></div>
                                    @endforeach
                                </div>
                            </div>
                        </li>
                    @endisset--}}
                    @guest
                        <li>
                            <a class="nav-link {{ request()->routeIs('guest.course.index','guest.course.show') ? 'active' : '' }}" href="{{ route('guest.course.index') }}">Courses</a>
                        </li>
                        <li>
                            <a class="nav-link {{ request()->routeIs('contact.us') ? 'active' : '' }}" href="{{ route('contact.us') }}">Contact Us</a>
                        </li>
                    @else
                        <li>
                            <a class="nav-link {{ request()->routeIs('course.index','course.show') ? 'active' : '' }}" href="{{ route('course.index') }}">Courses</a>
                        </li>
                        @can('create', \App\Course::class)
                            <li>
                                <a class="nav-link {{ request()->routeIs('course.create') ? 'active' : '' }}" href="{{ route('course.create') }}">Create Course</a>
                            </li>
                        @endcan
                        <div class="nav-item mt-1 mx-3">
                            <form action="{{ route('search') }}" method="get" class="position-relative">
                                @csrf
                                <div class="d-flex position-relative">
                                    <input class="form-control search-box" type="search" id="search" name="search" placeholder="Search Courses..." aria-label="Search" autocomplete="off">
                                    <button class="btn btn-outline-dark btn-search btn-sm" type="submit"><span data-feather="search" class="p-1"></span></button>
                                </div>
                                <div class="position-absolute w-100">
                                    <ul class="list-group" id="suggestions">

                                    </ul>
                                </div>
                            </form>
                        </div>
                        <div class="nav-item dropdown" id="notification">
                            <a class="nav-link notification-button" type="button" id="notificationButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"
                               onclick="{{ auth()->user()->unreadNotifications->markAsRead() }}">
                                <span data-feather="bell" class="notification-icon"></span>
                                @if(auth()->user()->unreadNotifications->count())
                                    <span class="badge badge-danger">{{ auth()->user()->unreadNotifications->count() }}</span>
                                @endif
                            </a>
                            <div>
                                <div class="dropdown-menu dropdown-menu-right bg-light border-0" aria-labelledby="notificationButton">
                                    @foreach(auth()->user()->unreadNotifications as $notification)
                                        <span class="dropdown-item">
                                            @if($notification->type === \App\Notifications\PaymentReceived::class)
                                                Your Payment of {{ $notification->data['amount'] }} for {{ $notification->data['course'] }}
                                                <br>has been received. Check email for details.
                                            @elseif($notification->type === \App\Notifications\PaymentConfirmed::class)
                                                Your Payment for {{ $notification->data['course'] }} has been confirmed. You are now enrolled into the course.
                                            @elseif($notification->type === \App\Notifications\PaymentRejected::class)
                                                Your Payment for {{ $notification->data['course'] }} has been rejected. Please try again or contact support.
                                            @elseif($notification->type === \App\Notifications\AccountVerified::class)
                                                Your account has been verified. You can now teach in our platform.
                                            @elseif($notification->type === \App\Notifications\Enrolled::class)
                                                You have been enrolled into the course {{ $notification->data['course'] }}.
                                            @endif
                                        </span>
                                        <hr>
                                    @endforeach
                                    <span class="dropdown-item">
                                <a href="{{ route('notifications') }}">see all notifications</a>
                            </span>
                                </div>
                            </div>
                        </div>
                        <li class="nav-item dropdown">
                            <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                {{ Auth::user()->name }} <span class="caret ml-1"></span>
                            </a>

                            <div class="dropdown-menu dropdown-menu-right border-0" aria-labelledby="navbarDropdown">
                                @if(Auth::user()->hasRole('STUDENT'))
                                    <a href="{{ route('wishlist.index') }}" class="dropdown-item border-bottom">
                                        <span data-feather="bookmark" class="p-1"></span>Wishlists
                                    </a>
                                @endif
                                <a href="{{ route('profile') }}" class="dropdown-item border-bottom">
                                    <span data-feather="user" class="p-1"></span>My Account
                                </a>
                                <a class="dropdown-item" href="{{ route('logout') }}"
                                   onclick="event.preventDefault();
                                            document.getElementById('logout-form').submit();">
                                    <span data-feather="power" class="p-1"></span>{{ __('Logout') }}
                                </a>
                                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                    @csrf
                                </form>
                            </div>
                        </li>
                    @endguest
                </ul>
            </div>
        </div>
    </nav>
</header>
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
        $('#notification').on('hidden.bs.dropdown', function(){
            location.reload();
        });
    });
</script>
