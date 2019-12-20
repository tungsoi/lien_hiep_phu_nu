<html lang="en">
<head>
<title>{{ config('admin.name') }}</title>

    <meta charset="utf-8">
    <meta name="csrf-token" content="EVLv1jVHQrJMNA0j0ghF51A575bcWwXL90LIPewA">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <meta name="description" content="Benchmark your current experimentation program maturity in 7 minutes and get proven strategies to develop an insight-driving growth machine.">
    <link rel="shortcut icon" href="/img/favicon2.png" type="image/png">

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Oswald:300,400" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300italic,300,400,600" rel="stylesheet">

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="{{ asset('asset/css/dashboard.css') }}">
    <link rel="stylesheet" href="{{ asset('asset/css/custom.css') }}">

</head>

<body>
    <div id="app">
        <div class="layout">
            <div class="menu">
                <div class="row">
                    <a><i class="fa fa-user" aria-hidden="true"></i> &nbsp;{{ $member->name }}</a>
                    <a href="{{ route('member.getLogout') }}"><i class="fa fa-sign-out" aria-hidden="true"></i> {{ trans('admin.logout') }}</a>
                </div>
            </div>
            <main>
                <div id="content" class="white mg-t40"">
                    <div class="content-container">
                        <div class="category container">
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="category-box question">
                                        <center> <h2 class="question-title" style="text-transform: uppercase">{{ $week->name }}</h2></center>
                                        <table class="table table-bordered">
                                            <thead>
                                                <tr  align="center">
                                                    <th>Thời gian diễn ra</th>
                                                    <th>Người dự thi</th>
                                                    <th>Số điện thoại</th>
                                                    <th>Ngày dự thi</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr  align="center">
                                                    <td>{{ date('H:i - d/m/Y', strtotime($week->date_start)) .' đến '. date('H:i - d/m/Y', strtotime($week->date_end))  }}</td>
                                                    <td>{{ $member->name }}</td>
                                                    <td>{{ $member->mobile_phone }}</td>
                                                    <td>{{ date('d/m/Y', strtotime(now())) }}</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>

                                    <form id="exam-form" class="form-horizontal" role="form" method="POST" action="{{ route('member.storeExam') }}">
                                        {{ csrf_field() }}
                                        <input type="hidden" name="member_id" value="{{ $member->id }}">
                                        <input type="hidden" name="week_id" value="{{ $week->id }}">
                                        <hr>
                                        @if (isset($week))
                                            @foreach ($week->questions as $key => $question)
                                                <div class="category-box question">
                                                    <h2 class="question-title">{{$key+1}}. {{ $question->title }}</h2>
                                                    @if ($question->answers->count() > 0)
                                                        @foreach ($question->answers as $key => $answer)
                                                            <div class="btn btn-form choice answer-item" data-id="{{ $answer->id }}">{{ $order[$key] }}. {{ $answer->content }}</div>
                                                        @endforeach
                                                    @endif

                                                    <input type="hidden" class="answer_correct" name="question[{{$question->id}}][answer_correct]" value="">
                                                </div>
                                            @endforeach
                                        @endif
                                        <hr>
                                        <div class="category-box question">
                                            <h2 class="question-title" style="">Dự đoán số người trả lời đúng</h2>
                                            <input type="number" class="people_number form-control" name="people_number" value="" required="required" placeholder="Vui lòng dự đoán số người trả lời">
                                        </div>
                                        <hr>
                                        <div class="category-box question">
                                            <button class="btn btn-success" id="btn-submit">Hoàn thành</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
    <script>
        $('.answer-item').click(function () {
            $(this).parent().find('.answer-item').removeClass('answer-active');
            $(this).addClass('answer-active');

            $(this).parent().find('input[type="hidden"].answer_correct').val($(this).attr('data-id'));
        });
    </script>
</body>

</html>
