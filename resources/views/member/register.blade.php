@extends('member.master')

@section('style')
@endsection

@section('content')
<div id="wizard_container">
    <form id="wrapped" class="form-horizontal" role="form" method="POST" action="{{ route('member.postRegister') }}">
        <div id="middle-wizard">
            <div class="step">
                <center><h2 class="main_question uppercase bold">{{ trans('admin.register') }}</h2></center><hr>
                {{ csrf_field() }}
                @if(session('register_success'))
                    <label class="control-label" for="inputError" style="color: green">
                        <i class="fa fa-times-circle-o"></i> {{ session()->get('register_success') }}
                    </label>
                    <br> <br>
                @endif
                <div class="form-group{{ isset($errors) && $errors->has('name') ? ' has-error' : '' }}">
                    <input id="name" type="text" class="form-control" name="name" value="{{ old('name') }}"  autofocus placeholder="{{ trans('admin.name') }}">
                    @if (isset($errors) && $errors->has('name'))
                        <label id="name-error" class="error" for="name">{{ $errors->first('name') }}</label>
                    @endif
                </div>

                <div class="form-group{{ isset($errors) && $errors->has('mobile') ? ' has-error' : '' }}">
                    <input id="mobile" type="text" class="form-control" name="mobile" value="{{ old('mobile') }}"  autofocus placeholder="{{ trans('admin.mobile') }}">
                    @if (isset($errors) && $errors->has('mobile'))
                        <label id="name-error" class="error" for="mobile">{{ $errors->first('mobile') }}</label>
                    @endif
                </div>

                <div class="form-group{{ isset($errors) && $errors->has('email') ? ' has-error' : '' }}">
                    <input id="email" type="text" class="form-control" name="email" value="{{ old('email') }}"  autofocus placeholder="{{ trans('admin.email') }}">
                    @if (isset($errors) && $errors->has('email'))
                        <label id="email-error" class="error" for="mobile">{{ $errors->first('email') }}</label>
                    @endif
                </div>

                <div class="form-group{{ isset($errors) && $errors->has('gender') ? ' has-error' : '' }}">
                    <select name="gender" id="" class="form-control">
                        <option value="1" checked>{{ trans('admin.male') }}</option>
                        <option value="0">{{ trans('admin.female') }}</option>
                        <option value="2">{{ trans('admin.other') }}</option>
                    </select>
                    @if (isset($errors) && $errors->has('gender'))
                        <label id="gender-error" class="error" for="gender">{{ $errors->first('gender') }}</label>
                    @endif
                </div>

                <div class="form-group{{ isset($errors) && $errors->has('birthday') ? ' has-error' : '' }}">
                    <input type="text" class="form-control birthday" name="birthday" value="{{ old('birthday') }}" placeholder="{{ trans('admin.birthday') }}">
                    @if (isset($errors) && $errors->has('birthday'))
                        <label id="birthday-error" class="error" for="birthday">{{ $errors->first('birthday') }}</label>
                    @endif
                </div>

                <div class="form-group{{ isset($errors) && $errors->has('password') ? ' has-error' : '' }}">
                    <input id="password" type="password" class="form-control" name="password"  placeholder="{{ trans('admin.password') }}" value="{{ old('password') }}">
                    @if (isset($errors) && $errors->has('password'))
                        <label id="password-error" class="error" for="password">{{ $errors->first('password') }}</label>
                    @endif
                </div>

                <div class="form-group{{ isset($errors) && $errors->has('re-password') ? ' has-error' : '' }}">
                    <input id="password_confirmation" type="password" class="form-control" name="password_confirmation" placeholder="{{ trans('admin.re-password') }}">
                </div>
            </div>
        </div>

        <hr>

        <div class="form-group">
            <div class="">
                <button type="submit" class="btn btn_1 btn-primary rounded">
                    {{ trans('admin.register') }}
                </button>


                <a class="btn btn-link" href="{{ route('member.login') }}">
                    {{ trans('admin.login') }} ?
                </a>
            </div>
        </div>
    </form>
</div>

@endsection

@section('script')
<script src = "https://code.jquery.com/ui/1.10.4/jquery-ui.js"></script>
<script>
    $(document).ready(function() {
        jQuery(function ($)
        {
        $.datepicker.regional["vi-VN"] =
            {
                closeText: "Đóng",
                prevText: "Trước",
                nextText: "Sau",
                currentText: "Hôm nay",
                monthNames: ["Tháng một", "Tháng hai", "Tháng ba", "Tháng tư", "Tháng năm", "Tháng sáu", "Tháng bảy", "Tháng tám", "Tháng chín", "Tháng mười", "Tháng mười một", "Tháng mười hai"],
                monthNamesShort: ["Một", "Hai", "Ba", "Tư", "Năm", "Sáu", "Bảy", "Tám", "Chín", "Mười", "Mười một", "Mười hai"],
                dayNames: ["Chủ nhật", "Thứ hai", "Thứ ba", "Thứ tư", "Thứ năm", "Thứ sáu", "Thứ bảy"],
                dayNamesShort: ["CN", "Hai", "Ba", "Tư", "Năm", "Sáu", "Bảy"],
                dayNamesMin: ["CN", "T2", "T3", "T4", "T5", "T6", "T7"],
                weekHeader: "Tuần",
                dateFormat: "dd/mm/yy",
                firstDay: 1,
                isRTL: false,
                showMonthAfterYear: false,
                yearSuffix: ""
            };

            $.datepicker.setDefaults($.datepicker.regional["vi-VN"]);
        });

        $('.birthday').datepicker({
            format: 'yyyy-mm-dd',
            language: 'vi-VN',
            isRTL: false,
            autoclose:true,
            changeMonth: true,
            changeYear: true,
            yearRange: '1945:'+(new Date).getFullYear()
        });

    });
</script>
@endsection
