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

                @if(session('register_success'))
                    <label class="control-label" for="inputError" style="color: green">
                        <i class="fa fa-times-circle-o"></i> {{ session()->get('register_success') }}
                    </label>
                    <br> <br>
                @endif

                @if (isset($errors) && $errors->has('registed'))
                    <h5 class="registed">{{ trans('admin.register-successed') }}</h5> <br>
                @endif

                <div class="form-group">
                    <input id="mobile" type="text" class="form-control" name="mobile" value="{{ old('mobile') }}" autofocus placeholder="{{ trans('admin.mobile') }}">

                    @if (isset($errors) && $errors->has('mobile'))
                        <label id="mobile-error" class="error" for="mobile">{{ $errors->first('mobile') }}</label>
                    @endif
                </div>

                <div class="form-group{{ isset($errors) && $errors->has('password') ? ' has-error' : '' }}">
                    <input id="password" type="password" class="form-control" name="password"  placeholder="{{ trans('admin.password') }}" value="{{ old('password') }}">
                    @if (isset($errors) && $errors->has('password'))
                        <label id="password-error" class="error" for="password">{{ $errors->first('password') }}</label>
                    @endif
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
