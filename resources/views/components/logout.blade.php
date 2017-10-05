@if(Auth::guard('web')->check())
    <a href="{{ route('user.logout') }}"> Logout User</a>
@endif

@if(Auth::guard('admin')->check())
    <a href="{{ route('admin.logout') }}"> Logout Admin</a>
@endif
