@extends('member.master')

@section('content')
<div id="wizard_container">
    <form id="wrapped" class="form-horizontal" role="form" method="POST" action="{{ route('member.postLogin') }}">
        <div id="middle-wizard">
            <div class="step">
                <center>
                    <h2 class="uppercase bold">{{ trans('admin.login') }}</h2>
                </center>
                <hr>
                {{ csrf_field() }}

                @if (isset($errors) && $errors->has('registed'))
                    <h5 class="registed">{{ trans('admin.register-successed') }}</h5> <br>
                @endif

                <div class="form-group">
                    <label for="username" class="control-label">{{ trans('admin.mobile') }}</label>
                    <input id="username" type="text" class="form-control" name="mobile_phone" value="{{ old('username') }}" required autofocus placeholder="{{ trans('admin.place_holder_mobile_phone') }}">

                    @if (isset($errors) && $errors->has('mobile_phone'))
                        <label id="mobile_phone-error" class="error" for="mobile_phone">{{ $errors->first('mobile_phone') }}</label>
                    @endif
                </div>

                <div class="form-group">
                    <label for="password" class="control-label">{{ trans('admin.password') }}</label>
                    <input id="password" type="password" class="form-control" name="password" required placeholder="{{ trans('admin.place_holder_password') }}">
                </div>
            </div>
        </div>

        <hr>

        <div class="form-group">
            <div class="">
                <button type="submit" class="btn btn_1 btn-primary rounded">
                    {{ trans('admin.login') }}
                </button>

                <a class="btn btn-link" href="{{ route('member.register') }}">
                    {{ trans('admin.register') }} ?
                </a>
            </div>
        </div>
    </form>
</div>

@endsection

@section('script')
<script>
    $(document).ready(function() {
        $("#wrapped").validate({
            rules: {
                mobile_phone: "required",
                password: "required"
            },
            messages: {
                mobile_phone: '{{ trans('admin.place_holder_mobile_phone') }}',
                password: '{{ trans('admin.place_holder_password') }}',
            }
        });
    });
</script>
@endsection
