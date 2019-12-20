@extends('member.master')

@section('style')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker3.css">
@endsection

@section('content')
<div id="wizard_container">
    <form id="wrapped" class="form-horizontal" role="form" method="POST" action="{{ route('member.postRegister') }}">
        <div id="middle-wizard">
            <div class="step">
                <center><h3 class="main_question uppercase">{{ trans('admin.register') }}</h3></center><hr>
                {{ csrf_field() }}

                <div class="form-group{{ isset($errors) && $errors->has('name') ? ' has-error' : '' }}">
                    <label for="name" class="control-label">{{ trans('admin.name') }}</label>
                    <input id="name" type="text" class="form-control" name="name" value="{{ old('name') }}" required autofocus placeholder="{{ trans('admin.place_holder_name') }}">

                    @if (isset($errors) && $errors->has('name'))
                        <label id="name-error" class="error" for="name">{{ $errors->first('name') }}</label>
                    @endif
                </div>

                <div class="form-group{{ isset($errors) && $errors->has('mobile_phone') ? ' has-error' : '' }}">
                    <label for="mobile_phone" class="control-label">{{ trans('admin.mobile') }}</label>
                    <input id="mobile_phone" type="text" class="form-control" name="mobile_phone" value="{{ old('mobile_phone') }}" required autofocus placeholder="{{ trans('admin.place_holder_mobile_phone') }}">

                    @if (isset($errors) && $errors->has('mobile_phone'))
                        <label id="name-error" class="error" for="mobile_phone">{{ $errors->first('mobile_phone') }}</label>
                    @endif
                </div>


                <div class="form-group{{ isset($errors) && $errors->has('gender') ? ' has-error' : '' }}">
                    <label for="gender" class="control-label">{{ trans('admin.gender') }}</label>
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
                    <label for="birthday" class="control-label">{{ trans('admin.birthday') }}</label>
                    <input type="text" class="form-control birthday" name="birthday" value="{{ old('birthday') }}" placeholder="{{ trans('admin.place_holder_birthday') }}">

                    @if (isset($errors) && $errors->has('birthday'))
                        <label id="birthday-error" class="error" for="birthday">{{ $errors->first('birthday') }}</label>
                    @endif
                </div>

                <div class="form-group{{ isset($errors) && $errors->has('password') ? ' has-error' : '' }}">
                    <label for="password" class="control-label">{{ trans('admin.password') }}</label>
                    <input id="password" type="password" class="form-control" name="password" required placeholder="{{ trans('admin.place_holder_password') }}">

                    @if (isset($errors) && $errors->has('password'))
                        <span class="help-block">
                            <strong>{{ isset($errors) ? $errors->first('password') : '' }}</strong>
                        </span>
                    @endif
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
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.js"></script>
<script>
    $(document).ready(function() {
        $("#wrapped").validate({
            rules: {
                name: "required",
                mobile_phone: "required",
                password: "required",
                birthday: "required"
            },
            messages: {
                name: '{{ trans('admin.place_holder_name') }}',
                password: '{{ trans('admin.place_holder_password') }}',
                mobile_phone: '{{ trans('admin.place_holder_mobile_phone') }}',
                birthday: '{{ trans('admin.place_holder_birthday') }}',
            }
        });

        $('.birthday').datepicker({
            format: 'yyyy-mm-dd'
        });

    });
</script>
@endsection
