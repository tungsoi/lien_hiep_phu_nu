<!DOCTYPE html>
<html lang="{{ config('app.locale') }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ Admin::title() }} @if(isset($header)) | {{ $header }}@endif</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <link rel="shortcut icon" href="{{ asset('asset/img/fabicon.ico')}}" type="image/x-icon">

    {!! Admin::css() !!}
    <script src="{{ Admin::jQuery() }}"></script>
    {!! Admin::headerJs() !!}
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
    @if(config('admin.https'))
        <meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests">
    @endif
<!-- Google Tag Manager -->
    <script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
                new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
            j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
            'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
        })(window,document,'script','dataLayer','GTM-MN32CN8');</script>
    <!-- End Google Tag Manager -->

    <style>
        .cursor-pointer {
            cursor: pointer !important;
        }
    </style>
</head>
<body class="hold-transition {{config('admin.skin')}} ">

@if($alert = config('admin.top_alert'))
    <div style="text-align: center;padding: 5px;font-size: 12px;background-color: #ffffd5;color: #ff0000;">
        {!! $alert !!}
    </div>
@endif

<div class="wrapper">
    @include('admin::partials.header')
    @include('admin::partials.sidebar')
    <div class="content-wrapper" id="pjax-container">
        {!! Admin::style() !!}
        <div id="app">
            @yield('content')
        </div>

        {!! Admin::html() !!}
    </div>
    @include('admin::partials.footer')
</div>
<button id="totop" title="Go to top" style="display: none;"><i class="fa fa-angle-double-up"></i></button>
{{-- <div id="loading_flight" class="overlay" style="">
    <div class="loading ">
        <img class="loading__logo" alt="brazzer_logo" src="/img/logo-bas.png">
        <div class="loading__spinner"></div>
        <div class="loading__text" id="loadingAlertText"> Vui lòng đợi trong giây lát</div>
    </div>
</div> --}}

<button id="totop" title="Go to top" style="display: none;"><i class="fa fa-chevron-up"></i></button>
<!-- Google Tag Manager (noscript) -->
<noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-MN32CN8"
                  height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
<!-- End Google Tag Manager (noscript) -->
{{-- Script --}}
<script>
    function LA() {}
    LA.token = "{{ csrf_token() }}";
    LA.user = @json($_user_);

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': "{{ csrf_token() }}"
        }
    });
    $(function () {
        $(".grid-popup-link").magnificPopup({
            "type": "image",
            "gallery": {
                "enabled": true,
                "preload": [0, 2],
                "navigateByImgClick": true,
                "arrowMarkup": "<button title=\"%title%\" type=\"button\" class=\"mfp-arrow mfp-arrow-%dir%\"><\/button>",
                "tPrev": "Previous (Left arrow key)",
                "tNext": "Next (Right arrow key)",
                "tCounter": "<span class=\"mfp-counter\">%curr% of %total%<\/span>"
            }
        });
    });
</script>
<!-- REQUIRED JS SCRIPTS -->
{!! Admin::js() !!}
{!! Admin::script() !!}
<script>
    $('.grid-row-view').attr('data-toggle', 'tooltip');
    $('.grid-row-view').attr('title', "{{ trans('admin.view') }}");

    $('.grid-row-edit').attr('data-toggle', 'tooltip');
    $('.grid-row-edit').attr('title', "{{ trans('admin.edit') }}");

    $('.grid-row-delete').attr('data-toggle', 'tooltip');
    $('.grid-row-delete').attr('title', "{{ trans('admin.delete') }}");
</script>
</body>
</html>
