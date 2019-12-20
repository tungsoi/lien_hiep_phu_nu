<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <title>{{ config('admin.name') }}</title>
    <link rel="shortcut icon" href="{{ asset('asset/img/fabicon.png')}}" type="image/x-icon">
    <link href="https://fonts.googleapis.com/css?family=Work+Sans:400,500,600" rel="stylesheet">
    <link href="{{ asset('asset/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('asset/css/menu.css')}}" rel="stylesheet">
    <link href="{{ asset('asset/css/style.css')}}" rel="stylesheet">
    <link href="{{ asset('asset/css/vendors.css')}}" rel="stylesheet">
    <link href="{{ asset('asset/css/custom.css')}}" rel="stylesheet">

    @yield('style')
    <script src="{{ asset('asset/js/modernizr.js')}}"></script>

</head>

<body>
	<div class="container-fluid full-height">
		<div class="row row-height">
			<div class="col-lg-6 content-left">
				<div class="content-left-wrapper">
                    <a href="index.html" id="logo"><img src="{{ asset('asset/img/logo.png')}}" alt="" width="49" height="35"></a>
					<div id="social">
						<ul>
							<li><a href="#0"><i class="icon-facebook"></i></a></li>
							<li><a href="#0"><i class="icon-twitter"></i></a></li>
							<li><a href="#0"><i class="icon-google"></i></a></li>
							<li><a href="#0"><i class="icon-linkedin"></i></a></li>
						</ul>
					</div>
					<!-- /social -->
					<div>
                        <figure><img src="{{ asset('asset/img/info_graphic_1.svg')}}" alt="" class="img-fluid"></figure>
                        <h2>{{ config('admin.name') }}</h2>
						<p>Hướng tới kỷ niệm 90 năm ngày thành lập Hội LHPN Việt Nam, (20/10/1930 - 20/10/2020), góp phần tuyên truyền cho thế hệ trẻ và toàn thể nhân dân về vai trò của Phụ nữ và đóng góp của Hội trong 90 năm qua</p>
						<a href="https://google.com" class="btn_1 rounded" target="_blank">TRANG CHỦ</a>
					</div>
					<div class="copy">© 2018 Wilio</div>
				</div>
				<!-- /content-left-wrapper -->
			</div>
			<!-- /content-left -->

			<div class="col-lg-6 content-right" id="start">
                @yield('content')
			</div>
			<!-- /content-right-->
		</div>
		<!-- /row-->
	</div>

	<!-- COMMON SCRIPTS -->
    <script src="{{ asset('asset/js/jquery-3.2.1.min.js')}}"></script>
    <script src="{{ asset('asset/js/common_scripts.min.js')}}"></script>
	<script src="{{ asset('asset/js/velocity.min.js')}}"></script>
    <script src="{{ asset('asset/js/functions.js')}}"></script>
    <script type="text/javascript" src="http://ajax.aspnetcdn.com/ajax/jquery.validate/1.13.1/jquery.validate.min.js"></script>
    @yield('script')
</body>
</html>
