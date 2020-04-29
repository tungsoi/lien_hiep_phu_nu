<!doctype html>
<html lang="en">
<head>
    @include ('member.header')

    <link rel="stylesheet" href="{{ asset('asset/css/dashboard.css') }}">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="{{ asset('asset/css/custom.css') }}">
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">

    <style>
        .toast-top-center, .toast-top-right {
            margin-top: 40px;
            opacity: 1;
        }
    </style>
</head>
<body>
    <div id="app">
        <div class="layout">
            @include('member.menu')
            <main>
                <div id="content" class="white bg-content">
                    <div class="content-container">
                        <div class="welcome">
                            <div class="row">
                                <div class="col-12">
                                    <div class="box">
                                        <br> <br>
                                        <div><img src="{{ asset('asset/img/logo-default.png') }}" alt="Liftmap" class="" width="300" height="auto"></div>
                                        <h1>Cuộc thi trắc nghiệm "Tìm hiểu 90 năm lịch sử Hội LHPN Việt Nam”</h1>
                                        <br>
                                        <h3>* Mục đích cuộc thi:</h3>
                                        <p>- Hướng tới kỷ niệm 90 năm ngày thành lập Hội LHPN Việt Nam, (20/10/1930 - 20/10/2020), góp phần tuyên truyền cho thế hệ trẻ và toàn thể nhân dân về vai trò của Phụ nữ và đóng góp của Hội trong 90 năm qua.</p>
                                        <p>- Tiếp tục phát huy truyền thống lịch sử và những bài học kinh nghiệm quý báu của phong trào phụ nữ được hun đúc nên từ truyền thống cách mạng vẻ vang; vận dụng linh hoạt, sáng tạo, hiệu quả vào công cuộc đổi mới, hội nhập quốc tế hiện nay.</p>
                                        <p>- Biểu dương, khen thưởng các cá nhân trả lời đúng và đầy đủ các tuần.</p>

                                        <br>
                                        <h3>* Giải thưởng cuộc thi:</h3>
                                        <p>Mỗi tuần có 03 giải thưởng, bao gồm: </p>
                                        <p>- 01 giải Nhất: Trị giá <b>500.000 đồng</b>.</p>
                                        <p>- 02 giải Nhì: Mỗi giải trị giá <b>300.000 đồng</b>.</p>
                                        <p>- 03 giải Ba: Mỗi giải trị giá <b>200.000 đồng</b>.</p>
                                        <p>Ngoài ra ban tổ chức sẽ trao một số giải thưởng phụ khác khi kết thúc đợt thi, bao gồm:</p>
                                        <p>- 01 Giải cho Hội Phụ nữ cấp tỉnh vận động nhiều người tham gia nhất: Trị giá <b>1.000.000 đồng</b>.</p>
                                        <p>- 01 Giải cho người dự thi nhỏ tuối nhất: Trị giá <b>300.000 đồng</b>.</p>
                                        <p>- 01 Giải cho người dự thi lớn tuổi nhất: Trị giá <b>200.000 đồng</b>.</p>
                                        <p><i>(Người nhận giải thưởng có trách nhiệm nộp thuế thu nhập cá nhân theo quy định)</i></p>

                                        <br>
                                        <h2>* Tuần thi đang diễn ra: {{ $week->name ?? "Chưa mở tuần thi"}}</h2>
                                        <h2>* Thời gian diễn ra: {{ isset($week->date_start) ? date('H:i - d/m/Y', strtotime($week->date_start)) .' đến '. date('H:i - d/m/Y', strtotime($week->date_end)) : 'Chưa mở tuần thi' }}</h2>
                                        <a class="btn btn-primary uppercase h42" @if(! isset($week->id)) style="cursor: not-allowed;" data-join="false" @else href="{{ route('member.exam', $week->id) }}" @endif >Tham gia thi</a>
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
    <script src="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

    @if (session()->has('send-exam'))
        <script>
            toastr.options = {
                "closeButton": false,
                "debug": false,
                "newestOnTop": false,
                "progressBar": false,
                "positionClass": "toast-top-right",
                "preventDuplicates": false,
                "onclick": null,
                "showDuration": "300",
                "hideDuration": "1000",
                "timeOut": "10000",
                "extendedTimeOut": "1000",
                "showEasing": "swing",
                "hideEasing": "linear",
                "showMethod": "fadeIn",
                "hideMethod": "fadeOut",
                "progressBar": true,
            }
            toastr["success"]("Gửi câu trả lời thành công");
        </script>
    @endif

    <script>
        $('.btn-primary').on('click', function () {
            let value = $(this).data('join');

            if (value != null && ! value) {

                toastr.options = {
                    "closeButton": false,
                    "debug": false,
                    "newestOnTop": false,
                    "progressBar": false,
                    "positionClass": "toast-top-center",
                    "preventDuplicates": false,
                    "onclick": null,
                    "showDuration": "300",
                    "hideDuration": "1000",
                    "timeOut": "10000",
                    "extendedTimeOut": "1000",
                    "showEasing": "swing",
                    "hideEasing": "linear",
                    "showMethod": "fadeIn",
                    "hideMethod": "fadeOut",
                    "progressBar": true,
                }

                toastr["error"]("Hiện tại chưa có tuần thi trắc nghiệm nào được mở. Vui lòng quay lại sau và tham gia thi.");
            }
        });
    </script>
</body>
</html>
