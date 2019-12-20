<!doctype html>
<html lang="en">
    <head>
        <title>{{ config('admin.name') }}</title>

        <meta charset="utf-8">
        <meta name="csrf-token" content="">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="shortcut icon" href="{{ asset('asset/img/fabicon.png')}}" type="image/x-icon">

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Oswald:300,400" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css?family=Open+Sans:300italic,300,400,600" rel="stylesheet">

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
                                            <div><img src="asset/img/logo.png" alt="Liftmap" class="logo"></div>
                                            <h1>Cuộc thi trắc nghiệm "Tìm hiểu 90 năm lịch sử Hội LHPN Việt Nam”</h1>
                                            <p>Mỗi tuần, Ban Tổ chức Cuộc thi đưa ra 08 câu hỏi thi trắc nghiệm về nội dung tìm hiểu lịch sử 90 năm Hội LHPN Việt Nam; đóng góp của phụ nữ trong công cuộc đổi mới Đất nước (trong đó có 01 đáp án đúng) và 01 câu dự đoán số người trả lời.</p>
                                            <h3>Thời gian tổ chức:</h3>
                                            <p>- Thời gian thi trắc nghiệm được tiến hành hàng tuần, bắt đầu tuần thi thứ nhất từ ngày 08/03/2020 và kết thúc vào ngày 08/07/2019 (4 tháng).</p>
                                            <p>- Thời gian thi mỗi tuần được tính từ 10h00’ thứ hai hằng tuần và kết thúc vào 9h00’ thứ hai tuần kế tiếp.</p>
                                            <p>- Mỗi người có thể dự thi nhiều lần/tuần, tuy nhiên chỉ được công nhận 01 kết quả đúng nhất và có thời gian trả lời sớm nhất trong số các lần dự thi.</p>
                                            <h3>Tuần thi đang diễn ra: {{ date('H:i - d/m/Y', strtotime($week->date_start)) .' đến '. date('H:i - d/m/Y', strtotime($week->date_end))  }}</h3>
                                            <a class="btn btn-primary uppercase h42" href="{{ route('member.exam', $week->id) }}">Tham gia thi</a>
                                            <br> <br><br> <br><br> <br><br> <br>
                                            <div class="wave wave-1"></div>
                                            <div class="wave wave-2"></div>
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
    </body>
</html>
