<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <!-- CSRF Token -->
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Scripts -->
        <script src="{{ asset('js/app.js') }}" defer></script>
        <script src="{{ asset('js/jquery-3.5.1.min.js') }}"></script>
        <script src="{{ asset('js/feather.min.js') }}"></script>
        <script src="{{ asset('js/ckeditor/ckeditor.js') }}"></script>
        <script src="{{ asset('js/ckeditor/adapters/jquery.js') }}"></script>

        <!-- Fonts -->
        <link rel="dns-prefetch" href="//fonts.gstatic.com">
        <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">
        <link href="{{ asset('assets/css/font-awesome.css') }}" rel="stylesheet" type="text/css">
        <link
            rel="stylesheet"
            href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css"
            integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p"
            crossorigin="anonymous"
        />
        <!-- Styles -->
        <link href="{{ asset('css/app.css') }}" rel="stylesheet">
        <link href="{{ asset('css/form.css') }}" rel="stylesheet">
        <link href="{{ asset('css/style.css') }}" rel="stylesheet">
        <link href="{{ asset('assets/css/font-awesome.css') }}" rel="stylesheet" type="text/css">
        <style>
            html, body, th {
                font-family: 'Nunito', sans-serif;
                font-weight: 200;
                margin: 0;
            }
            main{
                min-height: 100vh;
            }
            .btn.btn-light:hover{
                background-color: lightgray;
            }

            @media (max-width: 992px) {
                .container {
                    width: 100% !important;
                }
            }

            @auth
                @if(auth()->user()->hasRole('admin'))
                    @if(\Request::is('dashboard')||\Request::is('admin*'))
                        .content-wrapper {
                            margin-left: 175px;
                        }
                    @endif
                @endif
            @endauth

            @media screen and (max-width: 576px){
                .content-wrapper {
                    margin-left: 0;
                }
            }
        </style>
        @yield('styles')
    </head>
    <body>
        <div id="app">
            @include('layouts.navbar')
            @include('sweetalert::alert')
            @auth
                @if(auth()->user()->hasRole('admin'))
                    @if(\Request::is('dashboard')||\Request::is('admin*'))
                        @include('layouts.side-bar')
                    @endif
                @else
                    @if (\Request::route()->getname() == 'content.show' || \Request::route()->getname() == 'assessment.show')
                        @include('layouts.content-nav')
                    @endif
                @endif
            @endauth
            <main>
                <div class="content-wrapper">
                    @yield('content')
                </div>
            </main>
        </div>
        <footer>
            @guest
                @include('layouts.footer')
            @else
                @include('layouts.copyright')
            @endguest
        </footer>
        <script>
            feather.replace();
            Array.from(document.querySelectorAll('svg.feather[title]')).forEach((element) => {
                element.insertAdjacentHTML('afterbegin', `<title>${element.attributes.title.value}</title>`);
            });
        </script>
        <script type="text/javascript">
            $('textarea.editor').ckeditor();
        </script>
        <script type="text/javascript">
            $(function (){
                $("[data-toggle=popover]").popover();
            });
        </script>
        <script type="text/javascript">
            $(document).ready(function () {
                notifications();

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

                function notifications(){
                    var route = "{{ route('unread.notifications') }}";

                    $.ajax({
                        url: route,
                        method: "GET",
                        success: function (response){
                            $('#notification-list').html(response.output);

                            if (response.count)
                                $('#notification-count').html(response.count);
                            else
                                $('#notification-count').html('');
                        }
                    });
                }
                $('#notification').on('hidden.bs.dropdown', function(){
                    var route = "{{ route('read.notifications') }}";

                    $.ajax({
                        url: route,
                        method: "GET",
                    });

                    notifications();
                });

                $('#side-bar-collapse').click(function (){
                    $('#sidebar').toggleClass('open');
                });
            });
        </script>
        @yield('scripts')
    </body>
</html>
