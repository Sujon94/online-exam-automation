<html lang="en">
<head>
    <meta charset="utf-8">
    <!-- Styles -->
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" rel="stylesheet">
    <!--    <link href="https://fonts.googleapis.com/css?family=Noto+Serif" rel="stylesheet">-->
    <style rel="stylesheet">
        body {
            margin: 0; /* Remove default body margins */
            display: flex;
            justify-content: center;
            align-items: center;
            font-family: serif;
        }

        .container {
            position: relative; /* Position the container to enable absolute positioning of the footer */
            min-height: 100vh; /* Set minimum height to viewport height */
        }

        .cert-no {
            margin-top: 100pt;
            text-align: right;
            margin-right: 10pt;
        }

        .content {
            max-width: 800px;
            text-align: center;
            padding: 20px; /* Add some padding for better readability */
        }

        .st-name {
            margin-top: 100pt;
            color: black;
            font-weight: bold;
        }

        .course-desc {
            color: black;
            margin-top: 10pt;
        }

        .course-name {
            color: black;
            font-weight: bold;
        }

        .course-time {
            color: black;
        }

        .footer {
            position: absolute;
            bottom: 50pt;
            left: 50pt;
            width: 100%;
            text-align: left;
            padding: 10px;
        }
    </style>
    <title>{{__('Abadhut IT')}}</title>
</head>
<body>
<div class="container">
    <div class="header">
        <h4 class="cert-no">Certificate ID:{{__('PEVC: ')}}{{'#-'.''.'##-'.''.'####'}}</h4>
    </div>
    <div class="content">
        <h1 class="st-name"><b>{{__('Abadhut IT')}}</b></h1>
        @if($data['exam_type'] == \App\Enums\Exam\LExamType::PROFESSIONAL_EVALUATION)
            <h4 class="course-desc">for successful completion of {{__('99')}} days online training programme
                on</h4>
            <h3 class="course-name"><b>{{$data['course']}}</b></h3>
            <h4 class="course-time">Date: {{date('d-m-Y')}}
                to {{date('d-m-Y')}} Period: {{__('90')}} Hours,
                Batch {{__('90')}}th</h4>
        @else
            <h4 class="course-desc">for participation in</h4>
            <h3 class="course-name"><b>{{$data['exam']}}</b></h3>
            <br>
        @endif
    </div>
</div>

<div class="footer">
    <h4 class="issue-date"><span>Date of Issue:  </span>{{\App\Helpers\HelperClass::dateConvert()}}</h4>
</div>
</body>
</html>