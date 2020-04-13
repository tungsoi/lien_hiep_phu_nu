<div class="menu">
    <div class="container-fluid">
        <div class="col-xs-12" style="text-align: right; height: 40px; padding-top: 10px;">
            <a style="margin-right: 20px"><i class="fa fa-user" aria-hidden="true"></i> &nbsp;{{ $member->name ?? 'Guest' }}</a>
            <a href="{{ route('member.logout') }}"><i class="fa fa-sign-out" aria-hidden="true"></i> {{ trans('admin.logout') }}</a>
        </div>
    </div>
</div>
