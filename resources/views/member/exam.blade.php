<!doctype html>
<html lang="en">
<head>
    @include ('member.header')

    <link rel="stylesheet" href="{{ asset('asset/css/dashboard.css') }}">
    <link rel="stylesheet" href="{{ asset('asset/css/bootstrap3.min.css') }}">
    <link rel="stylesheet" href="{{ asset('asset/css/custom.css') }}">
</head>
<body>
    <div id="app">
        <div class="layout">
            @include('member.menu')
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
                                            <center><h2 class="uppercase"><label for="">- Danh sách câu hỏi -</label></h2></center>

                                            <form id="exam-form" class="form-horizontal" role="form" method="POST" action="{{ route('member.storeExam') }}">
                                                {{ csrf_field() }}
                                                <input type="hidden" name="user_id" value="{{ $member->id }}">
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

                                                            <input type="hidden" class="answer_correct" name="question[question_id_{{$question->id}}]" value="">
                                                        </div>
                                                    @endforeach
                                                @endif
                                                <br> <hr>
                                                <div class="category-box question">
                                                    <h2 class="question-title" style="">Dự đoán số người trả lời đúng</h2>
                                                    <input type="text" class="people_number form-control" name="people_number" value="" placeholder="Vui lòng dự đoán số người trả lời" @if (isset($errors) && $errors->has('people_number')) autofocus @endif required>
                                                    @if (isset($errors) && $errors->has('people_number'))
                                                        <label id="people_number_error" class="error" for="people_number" >{{ $errors->first('people_number') }}</label>
                                                    @endif
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

    <script src="{{ asset('asset/js/jquery34.min.js') }}"></script>
    <script src="{{ asset('asset/js/bootstrap3.min.js') }}"></script>
    <script src="{{ asset('asset/js/numberal.js') }}"></script>

    <script>
        $('.answer-item').click(function () {
            let answer_id = $(this).attr('data-id');
            // let value = $(this).parent().find('input[type="hidden"].answer_correct').val();
            $(this).parent().children().removeClass('answer-active');
            $(this).parent().find('input[type="hidden"].answer_correct').val("");
            $(this).addClass('answer-active');
            // if ($(this).hasClass('answer-active')) {
            //     $(this).removeClass('answer-active');
            //     value = value.replace(answer_id+",", "");
            // } else {
            //     $(this).addClass('answer-active');
            //     value += $(this).attr('data-id')+",";
            // }

            $(this).parent().find('input[type="hidden"].answer_correct').val(answer_id+",");
        });

        $('input[name="people_number"]').maskNumber({
            integer: true,
        });
    </script>
</body>

</html>
