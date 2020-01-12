<!doctype html>
<html lang="en">
<head>
    @include ('member.header')

    <link rel="stylesheet" href="{{ asset('asset/css/dashboard.css') }}">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
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
                <div id="content" class="white">
                    <div class="content-container">
                        <div class="welcome">
                            <div class="row">
                                <div class="col-12">
                                    <div class="box">
                                        <br> <br>
                                        <div><img src="{{ asset('asset/img/logo-default.png') }}" alt="Liftmap" class="" width="300" height="auto"></div>

                                        <div class="category-box question">
                                            <table class="table table-bordered">
                                                <thead>
                                                    <tr>
                                                        <th class="tx-center">Tuần thi</th>
                                                        <th class="tx-center">Thời gian diễn ra</th>
                                                        <th class="tx-center">Người dự thi</th>
                                                        <th class="tx-center">Số điện thoại</th>
                                                        <th class="tx-center">Ngày dự thi</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr  align="center">
                                                        <td>{{ $week->name }}</td>
                                                        <td>{{ date('H:i - d/m/Y', strtotime($week->date_start)) .' đến '. date('H:i - d/m/Y', strtotime($week->date_end))  }}</td>
                                                        <td>{{ $member->name }}</td>
                                                        <td>{{ $member->mobile_phone }}</td>
                                                        <td>{{ date('d/m/Y', strtotime(now())) }}</td>
                                                    </tr>
                                                </tbody>
                                            </table>

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

                                                            <input type="hidden" class="answer_correct" name="question[question_id_{{$question->id}}][answer_id]" value="">
                                                        </div>
                                                    @endforeach
                                                @endif
                                                <br>
                                                <div class="category-box question">
                                                    <h2 class="question-title" style="">Dự đoán số người trả lời đúng</h2>
                                                    <input type="text" class="people_number form-control" name="people_number" value="" required="required" placeholder="Vui lòng dự đoán số người trả lời">
                                                </div>

                                                <div class="category-box question">
                                                    <button class="btn btn-success" id="btn-submit">Nộp bài thi</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
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
    <script src="{{ asset('asset/js/numberal.js') }}"></script>

    <script>
        $('.answer-item').click(function () {
            $(this).addClass('answer-active');
            let vale = $(this).parent().find('input[type="hidden"].answer_correct').val();
            vale += $(this).attr('data-id')+",";
            $(this).parent().find('input[type="hidden"].answer_correct').val(vale);
        });

        $('input[name="people_number"]').maskNumber({
            integer: true,
        });
    </script>
</body>

</html>
