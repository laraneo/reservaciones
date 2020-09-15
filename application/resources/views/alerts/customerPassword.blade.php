@if(Session::has('password_error'))
    <div class="alert alert-danger">{{session('password_error')}}</div>
@endif


@if(Session::has('password_changed'))
    <div class="alert alert-success">{{session('password_changed')}}</div>
@endif