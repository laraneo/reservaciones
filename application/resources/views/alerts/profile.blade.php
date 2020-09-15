@if(Session::has('profile_error'))
    <div class="alert alert-danger">{{session('profile_error')}}</div>
@endif

@if(Session::has('profile_updated'))
    <div class="alert alert-success">{{session('profile_updated')}}</div>
@endif