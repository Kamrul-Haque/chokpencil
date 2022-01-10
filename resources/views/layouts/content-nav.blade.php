<style>
    a.sidebar {
        -webkit-transition: .3s all ease;
        -o-transition: .3s all ease;
        transition: .3s all ease;
        font-size: 20px;
        padding-top: 10px;
    }
    a.child {
        -webkit-transition: .3s all ease;
        -o-transition: .3s all ease;
        transition: .3s all ease;
        font-size: 16px;
        padding-bottom: 10px;
    }
    a:hover, a:focus {
        text-decoration: none !important;
        outline: none !important;
        -webkit-box-shadow: none;
        box-shadow: none;
    }
    #sidebar {
        position: fixed;
        top: 13vh;
        width: 13vw;
        min-height: 100%;
        max-height: 100%;
        background: white;
        -webkit-transition: all 1s;
        -o-transition: all 1s;
        transition: all 1s;
        border-right: 1px solid lightgrey;
        z-index: 3;
        box-shadow: 1px 3px lightgray;
        overflow-y: scroll;
        overflow-x: hidden;
    }
    #sidebar ul.components {
        padding: 0;
    }
    #sidebar ul li {
        font-size: 16px;
    }
    #sidebar ul li > ul {
        margin-left: 10px;
    }
    #sidebar ul li > ul li {
        font-size: 16px;
    }
    #sidebar ul li a {
        display: block;
        color: black;
    }
    #sidebar ul li a:hover {
        color: dodgerblue;
    }
    #sidebar ul li.active > a {
        background: transparent;
    }

    a[data-toggle="collapse"] {
        position: relative;
    }
    .dropdown-toggle::after {
        display: block;
        position: absolute;
        top: 50%;
        right: 0;
        -webkit-transform: translateY(-50%);
        -ms-transform: translateY(-50%);
        transform: translateY(-50%);
    }
</style>
<div class="d-flex">
    <nav id="sidebar" class="pt-5">
        <ul class="list-unstyled components">
            @foreach($module->course->modules as $module)
                <li>
                    <a href="#{{ str_replace(' ','',$module->module_name) }}" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle sidebar">
                        <p class="col-md-10">{{ $module->module_name }}</p>
                    </a>
                    <ul class="collapse list-unstyled" id="{{ str_replace(' ','',$module->module_name) }}">
                        @foreach($module->contents as $content)
                            <li>
                                <a href="{{ route('content.show', ['course'=>$module->course, 'module'=>$module, 'content'=>$content]) }}" class="child ml-3 text-wrap">{{$content->title}}</a>
                            </li>
                        @endforeach
                        @foreach($module->assessments as $assessment)
                            @can('view', $assessment)
                            <li>
                                <a href="{{ route('assessment.show', ['course'=>$module->course, 'module'=>$module, 'assessment'=>$assessment]) }}" class="child ml-3 text-wrap">{{ Str::limit($assessment->title, 20, '...') }}</a>
                            </li>
                            @endcan
                        @endforeach
                    </ul>
                </li>
            @endforeach
        </ul>
    </nav>
</div>
