<style>
    a.sidebar {
        -webkit-transition: .3s all ease;
        -o-transition: .3s all ease;
        transition: .3s all ease;
        color: dodgerblue;
        font-size: 20px;
    }
    a.child {
        -webkit-transition: .3s all ease;
        -o-transition: .3s all ease;
        transition: .3s all ease;
        font-size: 14px;
    }
    a:hover, a:focus {
        text-decoration: none !important;
        outline: none !important;
        -webkit-box-shadow: none;
        box-shadow: none;
    }
    #sidebar {
        position: fixed;
        width: 175px;
        min-height: 100%;
        max-height: 100%;
        background: #23272b;
        color: #fff;
        -webkit-transition: all 1s;
        -o-transition: all 1s;
        transition: all 1s;
        border-right: 1px solid rgba(255, 255, 255, 0.1);
        z-index: 3;
        box-shadow: 1px 3px rgba(255, 255, 255, 0.1);
        overflow-y: auto;
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
        font-size: 14px;
    }
    #sidebar ul li a {
        padding: 15px 0;
        display: block;
        color: rgba(255, 255, 255, 0.8);
        /*border-bottom: 1px solid rgba(255, 255, 255, 0.1);*/
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
    .last:hover{
        color: white;
    }
    @media screen and (max-width: 576px){
        #sidebar{
            position: absolute;
            z-index: 9999;
            transition: width 0.5s ease-in-out;
        }
    }
    .open{
        width: 0 !important;
        border: 0 !important;
    }
</style>
<div class="wrapper d-flex align-items-stretch">
    <nav id="sidebar" class="add-padding pt-4">
        <div class="px-3">
            <ul class="list-unstyled components mb-5">
                <li class="active">
                    <a href="#subjectSubmenu" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle sidebar">Categories</a>
                    <ul class="collapse list-unstyled" id="subjectSubmenu">
                        <li>
                            <a href="{{ route('admin.category.index') }}" class="child">Index</a>
                        </li>
                        <li>
                            <a href="{{ route('admin.category.create') }}" class="child">Create</a>
                        </li>
                    </ul>
                </li>
                <li class="active">
                    <a href="#institutionSubmenu" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle sidebar">Institutions</a>
                    <ul class="collapse list-unstyled" id="institutionSubmenu">
                        <li>
                            <a href="{{ route('admin.institution.index') }}" class="child">Index</a>
                        </li>
                        <li>
                            <a href="{{ route('admin.institution.create') }}" class="child">Create</a>
                        </li>
                    </ul>
                </li>
                <li class="active">
                    <a href="#courseSubmenu" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle sidebar">Courses</a>
                    <ul class="collapse list-unstyled" id="courseSubmenu">
                        <li>
                            <a href="{{ route('course.index') }}" class="child">Index</a>
                        </li>
                        <li>
                            <a href="{{ route('course.create') }}" class="child">Create</a>
                        </li>
                    </ul>
                </li>
                <li class="active">
                    <a href="#paymentInfoSubmenu" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle sidebar">Payment Info</a>
                    <ul class="collapse list-unstyled" id="paymentInfoSubmenu">
                        <li>
                            <a href="{{ route('admin.payment-info.index') }}" class="child">Index</a>
                        </li>
                        <li>
                            <a href="{{ route('admin.payment-info.create') }}" class="child">Create</a>
                        </li>
                    </ul>
                </li>
                <li class="active">
                    <a href="#paymentSubmenu" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle sidebar">Payments</a>
                    <ul class="collapse list-unstyled" id="paymentSubmenu">
                        <li>
                            <a href="{{ route('admin.payment.index') }}" class="child">Index</a>
                        </li>
                    </ul>
                </li>
                <li class="active">
                    <a href="#enquirySubmenu" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle sidebar">Enquiries</a>
                    <ul class="collapse list-unstyled" id="enquirySubmenu">
                        <li>
                            <a href="{{ route('admin.enquiry.index') }}" class="child">Index</a>
                        </li>
                    </ul>
                </li>
                <li class="active">
                    <a href="#studentSubmenu" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle sidebar">Students</a>
                    <ul class="collapse list-unstyled" id="studentSubmenu">
                        <li>
                            <a href="{{ route('admin.user.index') }}" class="child">Index</a>
                        </li>
                        <li>
                            <a href="{{ route('admin.user.create') }}" class="child">Create</a>
                        </li>
                    </ul>
                </li>
                <li class="active">
                    <a href="#instructorSubmenu" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle sidebar">Instructors</a>
                    <ul class="collapse list-unstyled" id="instructorSubmenu">
                        <li>
                            <a href="{{ route('admin.instructor.index') }}" class="child">Index</a>
                        </li>
                        <li>
                            <a href="{{ route('admin.instructor.create') }}" class="child">Create</a>
                        </li>
                    </ul>
                </li>
                <li class="active pb-2">
                    <a href="#adminSubmenu" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle sidebar last text-danger">Admins</a>
                    <ul class="collapse list-unstyled" id="adminSubmenu">
                        <li>
                            <a href="{{ route('admin.admin.index') }}" class="child">Index</a>
                        </li>
                        <li>
                            <a href="{{ route('admin.admin.create') }}" class="child">Create</a>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>
    </nav>
</div>
