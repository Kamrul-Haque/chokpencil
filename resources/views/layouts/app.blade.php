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

            @auth
                @unless(Request::is('/'))
                    .content-wrapper {
                        margin-left: 15vw;
                        margin-right: 15vw;
                    }
                @endunless
            @endauth
        </style>
        @yield('styles')
    </head>
    <body>
        <div id="app">
            @include('layouts.navbar')
            @include('sweetalert::alert')
            @auth
                @if(auth()->user()->hasRole('admin'))
                    @unless(Request::is('/'))
                        @include('layouts.side-bar')
                    @endunless
                @else
                    @if (\Request::route()->getname() == 'content.show')
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
    </body>
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
    @yield('scripts')
</html>
