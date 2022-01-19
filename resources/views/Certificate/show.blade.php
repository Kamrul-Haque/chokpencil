<!DOCTYPE html>
<html lang="en">
<head>
    <title>Certificate</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <style>
        .border{
            border: 10px solid dodgerblue;
            width: 650px;
            height: 450px;
        }
        .inner-border{
            margin: 2px;
            border: 2px solid grey;
            width: 642px;
            height: 442px;
        }
        .content{
            margin: 15px;
        }
        .heading{
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding-bottom: 0;
            margin-bottom: 0;
        }
        .logo{
            padding-bottom: 5px;
            border-bottom: 1px solid lightgray;
        }
        p.statement{
            margin-top: 0;
            font-size: 12px;
            font-weight: 100;
        }
        .course{
            text-transform: uppercase;
            color: dodgerblue;
        }
        .authorization{
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
    </style>
</head>
<body>
    <div class="border">
        <div class="inner-border">
            <div class="content">
                <div class="heading">
                    <img src="{{ asset('images/logo.png') }}"
                         height="30px"
                         width="auto"
                         alt="logo"
                         class="logo">
                    <p>{{ $certificate->created_at->toDateString() }}</p>
                </div>
                <p class="statement">
                    Statement of Accomplishment
                </p>
                <br><br>
                <h4><b>{{ $certificate->student->name }}</b>,</h4>
                <p>has successfully completed an online offering of</p>
                <h3 class="course">{{ $course->title }}</h3>
                <p>with required marks.</p>
                <br><br>
                <div class="authorization">
                    <p>
                        <b>{{ $course->instructors->first()->name }}</b>
                        <br>
                        {{ $course->instructors->first()->instructor->designation }}
                        <br>
                        {{ $course->instructors->first()->instructor->department }}
                        <br>
                        <b>{{ $course->instructors->first()->instructor->institution }}</b>
                    </p>
                    <img src="{{ $course->institution->logo_path }}"
                         height="35px"
                         width="auto"
                         alt="logo">
                </div>
            </div>
        </div>
    </div>
</body>
</html>
