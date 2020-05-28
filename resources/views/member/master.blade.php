<!DOCTYPE html>
<html lang="en">
<head>
    @include('member.header')

    <link href="{{ asset('asset/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('asset/css/menu.css')}}" rel="stylesheet">
    <link href="{{ asset('asset/css/style.css')}}" rel="stylesheet">
    <link href="{{ asset('asset/css/vendors.css')}}" rel="stylesheet">
    <link href="{{ asset('asset/css/custom.css')}}" rel="stylesheet">
    <script src="{{ asset('asset/js/modernizr.js')}}"></script>
    <link rel="stylesheet" href="{{ asset('asset/css/bootstrap-datepicker3.css')}}">
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <link rel="stylesheet" href="{{ asset('asset/css/toastr.min.css') }}">
    @yield('style')
</head>

<body>
	<div class="container-fluid full-height">
		<div class="row row-height">
			<div class="col-lg-6 content-left">
				<div class="content-left-wrapper">
                    <a href="/" id="logo"><img src="{{ asset('asset/img/logo-default.png')}}" alt="" width="300" height="auto"></a>
					<div>
                        <figure><img src="{{ asset('asset/img/info_graphic_1.svg')}}" alt="" class="img-fluid"></figure>
                        <h2 class="master-title" style="text-transform: uppercase">Cuộc thi trắc nghiệm</h2>
						<p class="master-desciption">"Tìm hiểu 90 năm hình thành và phát triển <br>Hội Liên hiệp Phụ nữ Việt Nam"</p>
						<a href="http://hoilhpn.org.vn/" class="btn_1 rounded" target="_blank">CỔNG TTĐT HỘI LHPN VIỆT NAM</a>
					</div>
					<div class="copy">© Bản quyền thuộc về Hội Liên hiệp Phụ nữ Việt Nam</div>
				</div>
			</div>

			<div class="col-lg-6 content-right" id="start">
                @yield('content')
			</div>
		</div>
	</div>

    <script src="{{ asset('asset/js/jquery-3.2.1.min.js')}}"></script>
    <script src="{{ asset('asset/js/common_scripts.min.js')}}"></script>
	<script src="{{ asset('asset/js/velocity.min.js')}}"></script>
    <script src="{{ asset('asset/js/functions.js')}}"></script>
    <script type="text/javascript" src="http://ajax.aspnetcdn.com/ajax/jquery.validate/1.13.1/jquery.validate.min.js"></script>
    <script src="{{ asset('asset/js/toastr.min.js')}}"></script>
    @yield('script')
</body>
</html>
