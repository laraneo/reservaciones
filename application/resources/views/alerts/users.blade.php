@if(Session::has('user_created'))
    <div class="alert alert-success">{{session('user_created')}}</div>
@endif

@if(Session::has('user_deleted'))
    <div class="alert alert-success">{{session('user_deleted')}}</div>
@endif

@if(Session::has('user_updated'))
    <div class="alert alert-success">{{session('user_updated')}}</div>
@endif